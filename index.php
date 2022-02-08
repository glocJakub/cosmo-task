<?php

require_once('Services/ConvertPhone.php');
use Services\ConvertPhone;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json");

    if (!empty($_POST['textToConvert'])) {
        try {
            $convertPhone = new ConvertPhone();
            echo json_encode([
                'status' => 200,
                'data' => $convertPhone->convertToNumeric($_POST['textToConvert'])
            ]);
        } catch (Exception $exception) {
            echo json_encode([
                'status' => $exception->getCode(),
                'data' => 'Error: '.$exception->getMessage()
            ]);
        }
    }
    return false;
}

?>


<html>
<head>
    <title>Cosmo zadanie</title>
    <meta content="utf-8">
    <style></style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<div class="w-full h-full bg-slate-200">
    <div class="grid place-items-center h-screen">
        <div class="bg-white shadow-md rounded px-8 py-6 w-1/4">
            <form id="convertForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="textToConvert">
                        Text
                    </label>
                    <input required="required" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           name="textToConvert" type="text">
                </div>
                <div class="flex items-center">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            id="convertSubmit" type="submit">
                        Convert
                    </button>
                </div>
            </form>
            <div id="convertedTextContainer" class="hidden">
                <div class="block text-gray-700 text-sm font-bold mb-2">
                    Convert text
                </div>
                <div id="convertedText">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#convertForm').on('submit', function (e) {
        e.preventDefault();
        let formData = $('#convertForm').serialize();
        $.post("/", formData, function (response) {
            if(response.status == 200){
                let convertedTextContainer = $('#convertedTextContainer');
                convertedTextContainer.removeClass('hidden');
                convertedTextContainer.addClass('block');
                $('#convertedText').text(response.data);
            }
        });
    });

</script>
</body>
</html>


