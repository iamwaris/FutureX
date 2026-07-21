<?php

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'platform' => $this->faker->randomElement(['youtube', 'twitch', 'tiktok', 'instagram']),
            'type' => $this->faker->randomElement(['video', 'clip', 'short', 'vod']),
            'url' => $this->faker->url(),
            'category' => $this->faker->randomElement(['Valorant', 'Just Chatting', 'Charity', 'Vlog', 'Highlights']),
            'tags' => $this->faker->randomElements(
                ['funny', 'clutch', 'ranked', 'casual', 'react', 'tutorial', 'behind-the-scenes'],
                $this->faker->numberBetween(1, 3),
            ),
            'is_pinned' => false,
            'published_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
