<?php
$title = 'Ajout-panier';
$page = 'panierAjouter';
require_once('templates/header.php');
require_once('modules/product.php');
require_once('settings/pdo.php');
// si pas de session panier on va creer la session
if(!isset($_SESSION['panier'])){
    // création du panier
    $_SESSION['panier'] = array();
}

 // récupération de l'id dans le lien
if(isset($_GET['productId']) && isset($_GET['batchQty'])){//si un id a été envoyé alors :
    $id = $_GET['productId'];
    $qty = $_GET['batchQty'];
    // verifier grace a l'id si le produit existe dans la base de  données
    $product = getProductById($pdo, $id);
    if(!$product){
        //si ce produit n'existe pas
        die("Ce produit n'existe pas");
    }
    // ajouter le produit dans le panier ( Le tableau)

    if(isset($_SESSION['panier'][$id])){// si le produit est déjà dans le panier
        $_SESSION['panier'][$id]= $_SESSION['panier'][$id] + $qty; //Représente la quantité 
    }else {
        //si non on ajoute le produit
        $_SESSION['panier'][$id]= $qty ;
    }

    // redirection vers la page panier.php
    header("Location:panier.php");
} else {
    // récupération de l'id dans le lien
    if(isset($_GET['productId'])){//si un id a été envoyé alors :
        $id = $_GET['productId'] ;
        // verifier grace a l'id si le produit existe dans la base de  données
        $product = getProductById($pdo, $id);
        if(!$product){
            //si ce produit n'existe pas
            die("Ce produit n'existe pas");
        }
        // ajouter le produit dans le panier ( Le tableau)

        if(isset($_SESSION['panier'][$id])){// si le produit est déjà dans le panier
            $_SESSION['panier'][$id]++; //Représente la quantité 
        }else {
            //si non on ajoute le produit
            $_SESSION['panier'][$id]= 1 ;
        }

        // redirection vers la page panier.php
        header("Location:panier.php");
    }
}