<?php

if (isset($_POST['docx2pdf'])){
    if (isset($_FILES['document'])){
        
        $allowed =  array('docx');
        $filename = $_FILES['document']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) || mime_content_type($_FILES['document']['tmp_name'])!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            die(header("HTTP/1.0 666 error_file_type"));
        }
        
        require_once "../lib/phpoffice_phpword/vendor/autoload.php";
        \PhpOffice\PhpWord\Settings::setPdfRendererPath(realpath('../lib/phpoffice_phpword/vendor/mpdf/mpdf'));
        \PhpOffice\PhpWord\Settings::setPdfRendererName('MPDF');
        
        $name=uniqid('tmp_');
        move_uploaded_file( $_FILES['document']['tmp_name'], $name.'.docx');
        
        $phpWord = \PhpOffice\PhpWord\IOFactory::load(realpath($name.'.docx'));
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        header('Content-Disposition: inline; filename="exapmle.pdf"');
        header('Content-type: application/pdf');
        $objWriter->save('php://output');
        unlink($name.'.docx');
    }
}

?>