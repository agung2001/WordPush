<?php
    if(isset($_POST['url_to']) && $_POST['url_to']) {
        $controller->migrate($_POST);
    } elseif(isset($_POST['name']) && $_POST['name']) {
        $controller->findDBInfo($_POST);
    }
?>

<div class="container">
    <h1 class="text-center">Wordpress Migrator</h1>
    <form class="form" method="post">
        <!-- Database Info -->
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="text-center">Database Info</h3>
                <select name="name" class="form-control" required>
                    <?php foreach($db->getDatabases() as $database): ?>
                        <option value="<?= $database ?>" <?php if($db->getName() && $db->getName()==$database) echo 'selected'; ?>>
                            <?= $database ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <input type="submit" class="btn pull-right" value="Find">
            </div>
        </div>

        <!-- Migrator -->
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="text-center">Table Informations</h3>
                <input type="text" class="form-control" name="prefix" placeholder="prefix" value="<?php if($db->getPrefix()) echo $db->getPrefix(); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 class="text-center">Migration Address</h3>
                <input type="text" class="form-control" name="url_from" placeholder="From" value="<?php if(isset($controller->getUrl()['from'])) echo $controller->getUrl()['from']; ?>"> <br>
                <input type="text" class="form-control" name="url_to" placeholder="To" value="<?php if(isset($controller->getUrl()['to'])) echo $controller->getUrl()['to']; ?>"> <br>
                <input type="checkbox" name="execute" value="1"> Execute <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <input type="submit" class="btn pull-right" value="Migrate">
            </div>
        </div>
    </form>

    <!-- Status -->
    <?php if($controller->getStatus()): ?>
    <div class="text-center">
        <h1>Status</h1>
        <p><?= $controller->getStatus() ?></p>
    </div>
    <?php endif; ?>
</div>
