<?php
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
header("access-control-allow-origin: *");
include_once 'api/api.php';
global $conn, $api;
?>
<Response>
    <Message>Hello, Mobile Monkey</Message>
</Response>