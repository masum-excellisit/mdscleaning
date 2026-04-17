<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageSectionController extends Controller
{
    // Sections that should always exist for MDS Cleaning
    protected array $defaultSections = [
        'intro'              => ['title' => 'Meet Our Founder',          'subtitle' => 'Intro / founder section on the home page', 'sort_order' => 1],
        'why_choose'         => ['title' => 'Why Choose Us?',            'subtitle' => 'Why-choose cards on home page',            'sort_order' => 2],
        'cta'                => ['title' => 'Contact Us for a Free Quote!', 'subtitle' => 'Home page contact/CTA section',         'sort_order' => 3],
        'about_hero'         => ['title' => 'About Us',                  'subtitle' => 'About page hero heading',                  'sort_order' => 4],
        'about_story'        => ['title' => 'Meet Our Founder',          'subtitle' => 'Founder story on about page',              'sort_order' => 5],
        'about_why'          => ['title' => 'Why Choose Us?',            'subtitle' => 'Why-choose cards on about page',           'sort_order' => 6],
        'about_details'      => ['title' => 'What Clients Can Expect',   'subtitle' => 'Detail cards on about page',               'sort_order' => 7],
        'services_hero'      => ['title' => 'Services',                  'subtitle' => 'Services page hero heading',               'sort_order' => 8],
        'service_guarantees' => ['title' => 'Simple, Flexible Scheduling','subtitle' => 'How-it-works cards on services page',     'sort_order' => 9],
        'contact_hero'       => ['title' => 'Contact Us',                'subtitle' => 'Contact page hero heading',                'sort_order' => 10],
        'cta_about'          => ['title' => 'Ready to work with a team that shows up?', 'subtitle' => 'Mini CTA on about page',    'sort_order' => 11],
        'cta_services'       => ['title' => 'Need help choosing the right service?',    'subtitle' => 'Mini CTA on services page', 'sort_order' => 12],
    ];

    // Which section_keys store a JSON items array in settings['items']
    protected array $itemsSections = ['why_choose', 'about_why'];

    // Which section_keys store a JSON cards array in settings['cards']
    protected array $cardsSections = ['about_details', 'service_guarantees'];

    // Which section_keys have an image in settings['image']
    protected array $imageSections = ['intro', 'about_story'];

    public function __construct(protected MediaService $media) {}

    public function index(): View
    {
        $this->ensureDefaults();
        $sections = HomepageSection::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage-sections.index', compact('sections'));
    }

    public function edit(int $id): View
    {
        $section = HomepageSection::findOrFail($id);
        return view('admin.homepage-sections.edit', compact('section'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $section = HomepageSection::findOrFail($id);

        $data = $request->validate([
            'title'        => ['nullable', 'string', 'max:255'],
            'subtitle'     => ['nullable', 'string', 'max:500'],
            'content'      => ['nullable', 'string'],
            'is_active'    => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'image'        => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'items'        => ['nullable', 'string'],   // newline-separated list
            'cards'        => ['nullable', 'array'],
            'cards.*.icon'  => ['nullable', 'string', 'max:100'],
            'cards.*.title' => ['nullable', 'string', 'max:200'],
            'cards.*.text'  => ['nullable', 'string'],
            'cta_heading'   => ['nullable', 'string', 'max:255'],
            'cta_body'      => ['nullable', 'string'],
        ]);

        $settings = $section->settings ?? [];

        // Image handling
        if (!empty($data['remove_image'])) {
            if (!empty($settings['image'])) {
                $this->media->delete($settings['image']);
            }
            $settings['image'] = null;
        }
        if ($request->hasFile('image')) {
            if (!empty($settings['image'])) {
                $this->media->delete($settings['image']);
            }
            $settings['image'] = $this->media->store($request->file('image'), 'sections', [1200, 800]);
        }

        // Items (newline list → JSON array)
        if (in_array($section->section_key, $this->itemsSections)) {
            $raw = $data['items'] ?? '';
            $settings['items'] = array_values(array_filter(array_map('trim', explode("\n", $raw))));
        }

        // Cards (structured repeater → JSON array)
        if (in_array($section->section_key, $this->cardsSections)) {
            $cards = [];
            foreach (($data['cards'] ?? []) as $card) {
                if (!empty(array_filter($card))) {
                    $cards[] = [
                        'icon'  => $card['icon'] ?? '',
                        'title' => $card['title'] ?? '',
                        'text'  => $card['text'] ?? '',
                    ];
                }
            }
            $settings['cards'] = $cards;
        }

        // CTA extras
        if (!empty($data['cta_heading'])) {
            $settings['cta_heading'] = $data['cta_heading'];
        }
        if (!empty($data['cta_body'])) {
            $settings['cta_body'] = $data['cta_body'];
        }

        $section->update([
            'title'      => $data['title'] ?? null,
            'subtitle'   => $data['subtitle'] ?? null,
            'content'    => $data['content'] ?? null,
            'is_active'  => (bool) ($data['is_active'] ?? false),
            'sort_order' => (int) ($data['sort_order'] ?? $section->sort_order ?? 0),
            'settings'   => $settings ?: null,
        ]);

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', "Section \"{$section->section_key}\" updated.");
    }

    public function toggle(int $id): RedirectResponse
    {
        $section = HomepageSection::findOrFail($id);
        $section->update(['is_active' => !$section->is_active]);
        return back()->with('success', 'Section ' . ($section->is_active ? 'enabled' : 'disabled') . '.');
    }

    protected function ensureDefaults(): void
    {
        foreach ($this->defaultSections as $key => $defaults) {
            HomepageSection::firstOrCreate(
                ['section_key' => $key],
                array_merge($defaults, ['is_active' => true])
            );
        }
    }
}
