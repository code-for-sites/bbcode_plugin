# bbcode_plugin
PHP Class to turn a string which contains BBCODE into HTML

Example:

```
$bb = new bbcode();
$comment = '[a]https://www.example.com[/a] [img]https://www.example.com/img.jpg[/img] [strong]test[/strong] [b]test[/b] [script]alert(true)[/script] [u]test[/u] ';
echo $bb->run($comment);
```

This would return:
```
<a href="https://www.example.com">https://www.example.com</a> <img src="https://www.example.com/img.jpg"></img> <strong>test</strong> <b>test</b> <script>alert(true)</script> <u>test</u>
```
