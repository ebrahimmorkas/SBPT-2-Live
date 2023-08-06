<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            user-select: none;
        }
    </style>
</head>
<body>
<?php
        echo "<script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool'></script>
        <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@x.x.x'></script>
        <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@latest'></script>
        <script>
            import DisableDevtool from 'disable-devtool';
            DisableDevtool(options);
        </script>
        <script>
        // Disable right-click
        document.addEventListener('contextmenu', (e) => e.preventDefault());

        function ctrlShiftKey(e, keyCode) {
        return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
        }

        document.onkeydown = (e) => {
        // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
        if (
            event.keyCode === 123 ||
            ctrlShiftKey(e, 'I') ||
            ctrlShiftKey(e, 'J') ||
            ctrlShiftKey(e, 'C') ||
            ctrlShiftKey(e, 'P') ||
            ctrlShiftKey(e, 'M') ||
            ctrlShiftKey(e, '7') ||
            (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
        )
            return false;
        };

        // Function to close the selection
        const closeSelection = () => {
        document.activeElement.blur(); // Blur the active element to remove focus
        };
        </script>
        ";
    ?>
</body>
</html>