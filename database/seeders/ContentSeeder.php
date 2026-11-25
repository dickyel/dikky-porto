<?php

namespace Database\Seeders;

use App\Models\HeroStat;
use App\Models\Service;
use App\Models\SiteProfile;
use App\Models\Testimonial;
use App\Models\Tool;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        SiteProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'greeting' => "Hey 👋 I'm Dikky",
                'headline' => "Designer &\nDeveloper",
                'hire_label' => 'Hire Me',
                'hire_url' => '#contact',
                'bio' => 'Lead Product Design and Developer based in Jakarta, crafting digital products with 8+ years of experience.',
                'photo' => 'src/foto.jpeg',
                'availability' => '(Available for Work)',
                'about_dark_1' => "Welcome to my portfolio! I'm Dikky,",
                'about_mute_1' => ' a passionate designer & developer who turns ideas into polished digital products.',
                'about_dark_2' => ' I help startups and founders ship interfaces that feel simple,',
                'about_mute_2' => ' memorable, and ready for real users.',
                'about_cta_label' => 'See my latest work',
                'services_heading' => "The coolest Services\nI provide!",
                'services_subtext' => 'From first sketch to shipped product — design systems, websites, and apps built with care.',
                'services_button_label' => 'Hire Me',
                'showcase_heading' => "Check out our\nawesome showcase!",
                'contact_eyebrow' => 'Have a project in mind?',
                'contact_heading' => "Let's build something\nworth shipping.",
                'contact_email' => 'hello@dikky.dev',
            ]
        );

        $tools = [
            ['name' => 'Figma', 'icon_key' => 'figma', 'sort_order' => 1],
            ['name' => 'Framer', 'icon_key' => 'framer', 'sort_order' => 2],
            ['name' => 'Webflow', 'icon_key' => 'webflow', 'sort_order' => 3],
            ['name' => 'After Effects', 'icon_key' => 'after-effects', 'sort_order' => 4],
        ];

        foreach ($tools as $tool) {
            Tool::query()->updateOrCreate(
                ['name' => $tool['name']],
                $tool + ['is_active' => true]
            );
        }

        $stats = [
            ['value' => '08+', 'label' => 'Years of experience', 'sort_order' => 1],
            ['value' => '120+', 'label' => 'Happy clients', 'sort_order' => 2],
            ['value' => '18+', 'label' => 'Countries', 'sort_order' => 3],
        ];

        foreach ($stats as $stat) {
            HeroStat::query()->updateOrCreate(
                ['label' => $stat['label']],
                $stat + ['is_active' => true]
            );
        }

        $services = [
            [
                'title' => 'UI/UX Design',
                'description' => 'End-to-end product design — research, wireframes, high-fidelity UI, and interactive prototypes that keep teams aligned.',
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=120&h=120&fit=crop',
                'preview_image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=640&h=800&fit=crop',
                'stats' => [
                    ['value' => '200+', 'label' => 'Web Sites'],
                    ['value' => '130+', 'label' => 'Projects Done'],
                    ['value' => '08+', 'label' => 'Years Exp'],
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'Web Development',
                'description' => 'Fast, accessible frontends with clean architecture — landing pages, marketing sites, and web apps that perform under pressure.',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=120&h=120&fit=crop',
                'preview_image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=640&h=800&fit=crop',
                'stats' => [
                    ['value' => '90+', 'label' => 'Sites Built'],
                    ['value' => '40+', 'label' => 'Web Apps'],
                    ['value' => '99%', 'label' => 'Lighthouse'],
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Motion Design',
                'description' => 'Micro-interactions and brand motion that make interfaces feel alive — without slowing the experience down.',
                'thumbnail' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=120&h=120&fit=crop',
                'preview_image' => 'https://images.unsplash.com/photo-1618005198919-d3d4b5a92ead?w=640&h=800&fit=crop',
                'stats' => [
                    ['value' => '60+', 'label' => 'Motion Sets'],
                    ['value' => '25+', 'label' => 'Brand Films'],
                    ['value' => '12+', 'label' => 'Awards'],
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'App Development',
                'description' => 'Cross-platform mobile experiences focused on clarity, speed, and conversion — from MVP to polished release.',
                'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=120&h=120&fit=crop',
                'preview_image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=640&h=800&fit=crop',
                'stats' => [
                    ['value' => '35+', 'label' => 'Apps Shipped'],
                    ['value' => '4.8', 'label' => 'Avg Rating'],
                    ['value' => '1M+', 'label' => 'Downloads'],
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['title' => $service['title']],
                $service + ['is_active' => true]
            );
        }

        $testimonials = [
            [
                'quote' => 'Dikky turned our messy brief into a product people actually love using. Clear, fast, and sharp.',
                'author_name' => 'Sarah Mitchell',
                'author_role' => 'CEO, Northlane',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop&crop=faces',
                'visual_image' => null,
                'featured' => false,
                'sort_order' => 1,
            ],
            [
                'quote' => 'Working with Dikky felt like adding a design partner, not a freelancer. The UI quality raised our whole brand.',
                'author_name' => 'James Carter',
                'author_role' => 'Founder, Voltgear',
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=faces',
                'visual_image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=280&fit=crop',
                'featured' => true,
                'sort_order' => 2,
            ],
            [
                'quote' => 'From wireframes to launch, every detail was intentional. Our conversion rate jumped in the first month.',
                'author_name' => 'Amina Rahman',
                'author_role' => 'CPO, Softly',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&h=80&fit=crop&crop=faces',
                'visual_image' => null,
                'featured' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $item) {
            Testimonial::query()->updateOrCreate(
                ['author_name' => $item['author_name']],
                $item + ['is_active' => true]
            );
        }
    }
}
