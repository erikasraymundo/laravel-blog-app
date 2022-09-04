<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/app.css">
   <script src="/app.js"></script>
   <title>My Blog Post</title>
</head>

<body>
   <article>
      <h1>
         <a href="<?= $post->slug ?>">
            <?= $post->title ?>
         </a>
      </h1>
      <p>
         <?= $post->body ?>
      </p>

   </article>
   <a href="/posts">Go back</a>
</body>

</html>