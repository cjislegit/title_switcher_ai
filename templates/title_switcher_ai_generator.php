<?php
global $wpdb;
$title_switcher_ai = $wpdb->prefix . "title_switcher_ai";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Switcher</title>
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <div class="container flex flex-row row w-50 mt-5">
            <div class="form-group col">
                <label for="industry">Industry</label>
                <input  id="industry" class="form-control info" placeholder="Enter Industry" type="text">
            </div>
            <div class="form-group col">
                <label for="city">City</label>
                <input  id="city" class="form-control info" placeholder="Enter City" type="text">
            </div>
            <div class="form-group col">
                <label for="state">State</label>
                <input  id="state" class="form-control info" placeholder="Enter State" type="text">
            </div>
            <div class="form-group col-3 row  align-items-end">
                <input id="generate" class="btn btn-primary btn-sm dblock" value="Generate Tag" type="button">
            </div>
        </div>
        <table class="table w-50 mt-5">
            <thead>
                <tr>
                    <th class="col w-50">Page</th>
                    <th class="col w-50">Title Tag</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <td class="col">Posts</td>
                    <td class="col"><input class="newTitles" type="text" name="" id="0"></td>
                </tr>
                <?php foreach (PUBLISHED_PAGES_AI as $id): ?>
                <tr>
                    <td class="col"><?= get_the_title($id) ?></td>
                    <td class="col"><input class="newTitles" type="text" name="" id="<?= $id ?>"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <input type="button" id="submit" class="btn btn-primary btn-sm d-block" value="Approve New Tags">
    </div>
</body>
</html>