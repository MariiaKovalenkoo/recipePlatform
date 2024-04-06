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

        $htmlContent = $this->generateRecipeHTML($recipe);
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        $imgPath = $_SERVER['DOCUMENT_ROOT'].$recipe->getImgPath();
        $imageExtension = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

        $pdf->Image($imgPath, $pdf->getX(), $pdf->getY() + 10, 100, 0, $imageExtension, '', '', false, 300, '', false, false, 0, false, false, false);

        $pdf->Output($recipe->getRecipeName() . '.pdf', 'D');
    }

    private function generateRecipeHTML($recipe): string
    {
        $html = '<h1 style="text-align: center;">' . $recipe->getRecipeName() . '</h1>';
        $html .= '<p><strong>Description:</strong> ' . $recipe->getDescription() . '</p>';
        $html .= '<p><strong>Ingredients:</strong> ' . nl2br($recipe->getIngredients()) . '</p>';
        $html .= '<p><strong>Instructions:</strong> ' . nl2br($recipe->getInstructions()) . '</p>';

        if ($recipe->getMealType() && $recipe->getMealType() !== 'NOT SPECIFIED') {
            $html .= '<p><strong>Meal Type:</strong> ' . ucfirst(strtolower($recipe->getMealType())) . '</p>';
        }

        if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') {
            $html .= '<p><strong>Cuisine Type:</strong> ' . ucfirst(strtolower($recipe->getCuisineType())) . '</p>';
        }

        if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') {
            $html .= '<p><strong>Dietary Preference:</strong> ' . ucfirst(strtolower($recipe->getDietaryPreference())) . '</p>';
        }

        return $html;
    }

}