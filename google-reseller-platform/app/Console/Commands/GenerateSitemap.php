<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Plan;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        Sitemap::create()
            ->add(Url::create('/')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(1.0))
            ->add(Url::create('/pricing')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.9))
            ->add(Url::create('/blog')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.8))
            ->add(Url::create('/login')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.3))
            ->add(Url::create('/register')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setPriority(0.3))
            ->add($this->getPlanUrls())
            ->add($this->getBlogPostUrls())
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully!');
    }

    /**
     * Get plan URLs for sitemap.
     */
    private function getPlanUrls()
    {
        $urls = [];
        
        Plan::active()->get()->each(function ($plan) use (&$urls) {
            $urls[] = Url::create("/checkout/{$plan->slug}")
                ->setLastModificationDate($plan->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7);
        });

        return $urls;
    }

    /**
     * Get blog post URLs for sitemap.
     */
    private function getBlogPostUrls()
    {
        $urls = [];
        
        Post::published()->get()->each(function ($post) use (&$urls) {
            $urls[] = Url::create("/blog/{$post->slug}")
                ->setLastModificationDate($post->published_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.6);
        });

        return $urls;
    }
}
