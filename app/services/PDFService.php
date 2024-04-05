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


        if ($recipe->getMealType() && $recipe->getMealType() !== 'NOT SPECIFIED') {
            $htmlContent .= '<div style="margin-bottom: 20px;">
                        <p><strong>Meal Type:</strong> ' . ucfirst(strtolower($recipe->getMealType())) . '</p>
                     </div>';
        }
        if ($recipe->getCuisineType() && $recipe->getCuisineType() !== 'NOT SPECIFIED') {
            $htmlContent .= '<div style="margin-bottom: 20px;">
                        <p><strong>Cuisine Type:</strong> ' . ucfirst(strtolower($recipe->getCuisineType())) . '</p>
                     </div>';
        }

        if ($recipe->getDietaryPreference() && $recipe->getDietaryPreference() !== 'NOT SPECIFIED') {
            $pdf->writeHTML('<p><strong>Dietary Preference:</strong> ' . ucfirst(strtolower($recipe->getDietaryPreference())) . '</p>', true, false, true, false, '');
        }

        $pdf->writeHTML($htmlContent, true, false, true, false, '');
        $imgPath = $_SERVER['DOCUMENT_ROOT'].$recipe->getImgPath();
        $imageExtension = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

        $pdf->Image($imgPath, $pdf->getX(), $pdf->getY() + 10, 100, 0, $imageExtension, '', '', false, 300, '', false, false, 0, false, false, false);

        $pdf->Output($recipe->getRecipeName() . '.pdf', 'D');
    }

    private function generateHTML($recipe){
        $htmlContent = '<div style="text-align: center; margin-bottom: 20px;">
                            <h1>{$recipe->getRecipeName()}</h1>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <p><strong>Description:</strong> {$recipe->getDescription()}</p>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <p><strong>Ingredients:</strong><br />" . nl2br($recipe->getIngredients()) . "</p>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <p><strong>Instructions:</strong><br />" . nl2br($recipe->getInstructions()) . "</p>
                        </div>
                        <div style="margin-bottom: 20px;">
                        <p><strong>Dietary Preference:</strong> ' . ucfirst(strtolower($recipe->getDietaryPreference())) . '</p>
                        </div>';

        $htmlContent = "<div style='border: 1px solid black; padding: 10px; margin-bottom: 10px;'>
                        <h2>{$ticket->getEventName()}</h2>
                        <p>Venue: {$ticket->getVenue()}</p>
                        <p>Date and Time: {$ticket->getStartDateTime()->format('Y-m-d H:i')} to {$ticket->getEndDateTime()->format('Y-m-d H:i')}</p>
                        <p>Name: {$ticket->getCustomerName()}</p>
                        <p>Additional Info: {$ticket->getNote()} </p>
                        </div>";
        return $htmlContent;
    }
}