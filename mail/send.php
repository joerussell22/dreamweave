<?php
header('Content-Type: application/json; charset=utf-8');
$to = 'studio@dreamweave.example';
$ok_url = '../thanks.html';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false]); exit; }
$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$intent = trim((string)($_POST['intent'] ?? ''));
$note = trim((string)($_POST['note'] ?? ''));
$hp = trim((string)($_POST['company'] ?? ''));
if ($hp !== '') { echo json_encode(['ok'=>true]); exit; }
if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) { http_response_code(422); echo json_encode(['ok'=>false]); exit; }
$subject = 'Dreamweave brief from '.$name;
$body = "Name: $name\nEmail: $email\nIntent: $intent\n\n$note\n";
$headers = 'From: Dreamweave <no-reply@'.($_SERVER['HTTP_HOST'] ?? 'localhost').">\r\nReply-To: $name <$email>\r\nContent-Type: text/plain; charset=UTF-8';
$sent = @mail($to, $subject, $body, $headers);
echo json_encode(['ok'=>(bool)$sent]);
