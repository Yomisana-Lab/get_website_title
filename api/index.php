<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['action'] == "get"){
        // Check if a URL parameter is provided
        if (isset($_POST['url'])) {
            $targetURL = $_POST['url'];
            echo extractTitle($targetURL);
        } else {
            echo json_encode(array('error' => 'URL parameter is missing'));
        }
        echo "OK";
    }
}


function extractTitle($url) {
    try {
        // Validate the URL
        if (!isValidURL($url)) {
            return json_encode(array('error' => 'Invalid URL'));
        }

        // Fetch the title from the target URL
        $content = file_get_contents($url);
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $title = $doc->getElementsByTagName('title')->item(0)->textContent;

        // Return the extracted title
        return json_encode(array('title' => $title));
    } catch (Exception $e) {
        // Handle errors
        return json_encode(array('error' => 'Error processing the URL'));
    }
}

function isValidURL($url) {
    // Add your URL validation logic here
    return filter_var($url, FILTER_VALIDATE_URL);
}
?>
