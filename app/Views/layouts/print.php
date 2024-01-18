<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIxITB | <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        html,
        body {
            height: auto;
            font-size: 9pt;
            /* changing to 10pt has no impact */
        }
    </style>
</head>

<body>
    <div class="content">
        <img src="<?= base_url('header.png') ?>" alt="" srcset="" style="max-width: 100%; width: 21cm">

        <!-- Render section -->
        <?= $this->renderSection('content') ?>
        <!-- ./render section -->

        <img src="<?= base_url('footer.png') ?>" alt="" srcset="" style="max-width: 100%; width: 21cm">
    </div>
</body>

</html>