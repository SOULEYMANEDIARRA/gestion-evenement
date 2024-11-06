<?php
require_once 'config.php';
if(isset($_GET['aaaa'])){
    header('location:page2.php');
}
?>
<div class=" centre1">
    <div class="index2 centre2">
        <div class="index3">
            <h1>Bienvenue </h1>
            <p class="p1">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellat eius consectetur odio temporibus voluptates
                paria
            </p>
            <form action="connexion.php" method="post">
                <button>Se connecte</button>
            </form>
            <br>
            <br>
            <form action="index2.php" method="post">
                <button>Créer un compte </button>
            </form>
        </div>
    </div>
</div>