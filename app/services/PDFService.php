<?php

namespace App\Services;

class PDFService
{
    public function generatePDF($recipe): void
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Recipe App');
        $pdf->SetTitle($recipe->getRecipeName());
        $pdf->setPrintFooter(false);
        $pdf->setPrintHeader(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $pdf->writeHTML('<h1 style="text-align: center;">' . $recipe->getRecipeName() . '</h1>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Description:</strong> ' . $recipe->getDescription() . '</p>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Ingredients:</strong> ' . nl2br($recipe->getIngredients()) . '</p>', true, false, true, false, '');
        $pdf->writeHTML('<p><strong>Instructions:</strong> ' . nl2br($recipe->getInstructions()) . '</p>', true, false, true, false, '');
        if ($recipe->getMealType() && $recipe->getMealType() !== 'NOT SPECIFIED'){
            $pdf->writeHTML('<p><strong>Meal Type:</strong> ' . ucfirst(strtolower($recipe->getMealType())) . '</p>', true, false, true, false, '');
        }
        if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') {
            $pdf->writeHTML('<p><strong>Cuisine Type:</strong> ' . ucfirst(strtolower($recipe->getCuisineType())) . '</p>', true, false, true, false, '');
        }
        if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') {
            $pdf->writeHTML('<p><strong>Dietary Preference:</strong> ' . ucfirst(strtolower($recipe->getDietaryPreference())) . '</p>', true, false, true, false, '');
        }

        $imgPath = $_SERVER['DOCUMENT_ROOT'].$recipe->getImgPath();
        $imageExtension = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

        $pdf->Image($imgPath, $pdf->getX(), $pdf->getY() + 10, 100, 0, $imageExtension, '', '', false, 300, '', false, false, 0, false, false, false);

        $pdf->Output($recipe->getRecipeName() . '.pdf', 'D');
    }
}