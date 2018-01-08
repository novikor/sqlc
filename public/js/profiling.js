$(document).ready(function() {
    $('code.sql').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});