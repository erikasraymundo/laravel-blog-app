<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class Post
{

   public $title;

   public $excerpt;

   public $slug;

   public $date;

   public $body;

   public function __construct($title, $excerpt, $slug, $date, $body)
   {
      $this->title = $title;
      $this->excerpt = $excerpt;
      $this->slug = $slug;
      $this->date = $date;
      $this->body = $body;
   }

   public static function all()
   {
      return cache()->rememberForever('posts.all', function () {
         return collect(File::files(resource_path("posts/")))
            ->map(fn ($file) => YamlFrontMatter::parseFile($file))
            ->map(
               fn ($document) => new Post(
                  $document->title,
                  $document->excerpt,
                  $document->slug,
                  $document->date,
                  $document->body()
               )
            )
            ->sortByDesc('date');
      });
   }

   public static function find($slug)
   {
      return cache()->
            remember("posts.{$slug}", 
            now()->addHour(1),
            fn() => static::all()->firstWhere('slug', $slug));
   }

   public static function findOrFail($slug)
   {
      $post = static::find($slug);

      if (!$post) {
         throw new ModelNotFoundException();
      }

      return $post;
   }
}
