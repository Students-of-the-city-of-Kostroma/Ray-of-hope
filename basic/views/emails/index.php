<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<h1>Emails</h1>
<ul>

<?php foreach ($emails as $email): ?>
    <li>
        <?= Html::encode("{$email->id} ({$email->email})") ?>:
        <?= $email->hash ?>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pag]) ?>