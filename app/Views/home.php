<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>CodeIgniter Home Page</title>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">CodeIgniter Home Page</h1>

    <?php if (session()->has('user')): ?>
      <div class="flex flex-col">
        <div class="flex items-center mb-4">
          <img src="https://placehold.it/100x100" class="rounded-full mr-4">
          <div>
            <h2 class="text-xl font-bold">
              <?php echo $user->username; ?>
            </h2>
            <p class="text-gray-500">
              <?php echo $user->username; ?>
            </p>
          </div>
        </div>

        <ul class="list-disc">
          <li><a href="/books/create">Create Book</a></li>
          <li><a href="/books">View Books</a></li>
          <li><a href="/logout">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <div class="flex flex-col">
        <a href="/login" class="btn btn-primary">Login</a>
        <a href="/register" class="btn btn-secondary">Register</a>
      </div>
    <?php endif; ?>

    <h2 class="text-xl font-bold mb-4">Last Published Books</h2>

    <ul class="list-grid grid-cols-2 gap-4">

    </ul>
  </div>
</body>

</html>
