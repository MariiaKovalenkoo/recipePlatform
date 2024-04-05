<?php
namespace App\Controllers;

use App\Services\RecipeService;

class RecipeDetailsController
{
    private RecipeService $recipeService;

    function __construct()
    {
        $this->recipeService = new RecipeService();
    }

    public function index(): void
    {
        session_start();
        $recipeId = $_GET['id'];
        $recipe = $this->recipeService->getRecipeById($recipeId);

        if ($recipe === null) {
            header('Location: /home');
            exit();
        }
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            if ($recipe->getUserId() === $_SESSION['user']->getUserId()) {
                require __DIR__ . '/../views/recipeDetails/userRecipe.php';
            } else {
                require __DIR__ . '/../views/recipeDetails/publicRecipe.php';
            }
        } else
            require __DIR__ . '/../views/recipeDetails/publicRecipe.php';
    }

    public function download($recipeId): void
    {
        session_start();
        $recipeId = $_GET['id'];
        $recipe = $this->recipeService->getRecipeById($recipeId);

        if ($recipe === null) {
            header('Location: /userpage');
            exit();
        }

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Recipe App');
        $pdf->SetTitle($recipe->getRecipeName());
        $pdf->SetSubject('Recipe');
        $pdf->SetKeywords('Recipe, PDF, Export');
        $pdf->SetHeaderData('', 0, $recipe->getRecipeName(), 'Recipe App', [0, 64, 255], [0, 64, 128]);
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML('<h1>' . $recipe->getRecipeName() . '</h1>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Description:</strong> ' . $recipe->getDescription() . '</p>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Ingredients:</strong> ' . nl2br($recipe->getIngredients()) . '</p>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Instructions:</strong> ' . nl2br($recipe->getInstructions()) . '</p>', true, false, true, false, '');
        if ($recipe->getMealType()) {
            $pdf->writeHTML('<p><strong>Meal Type:</strong> ' . ucfirst(strtolower($recipe->getMealType())) . '</p>', true, false, true, false, '');

        }

    }
}