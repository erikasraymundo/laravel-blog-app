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

      // return
      // collect(File::files(resource_path("posts/")))
      // ->map(fn ($file) => YamlFrontMatter::parseFile($file))
      //    ->map(
      //       fn ($document) => new Post(
      //          $document->title,
      //          $document->excerpt,
      //          $document->slug,
      //          $document->date,
      //          $document->body()
      //       )
      //    )
      //    ->sortByDesc('date');
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



      // $files = File::files(resource_path("posts/"));
      // $posts = array_map(function($file) {
      //    $document = YamlFrontMatter::parseFile($file);

      //    return new Post(
      //       $document->title,
      //       $document->excerpt,
      //       $document->slug,
      //       $document->date,
      //       $document->body()
      //    );
      // }, $files);


      // $posts = [];
      // foreach ($files as $file) {

      //    $document = YamlFrontMatter::parseFile($file);

      //    $posts[] = new Post(
      //       $document->title,
      //       $document->excerpt,
      //       $document->slug,
      //       $document->date,
      //       $document->body()
      //    );
      // }

      // return $posts;
   }

   public static function find($slug)
   {
      // $path = resource_path("posts/{$slug}.html");

      // if (!file_exists($path)) {
      //    throw new ModelNotFoundException();
      // }

      // return cache()->remember("posts.{$slug}", 300, fn () => file_get_contents($path));

      return static::all()->firstWhere('slug', $slug);
   }
}
