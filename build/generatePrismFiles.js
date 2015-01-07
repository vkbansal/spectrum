var page = require('webpage').create(),
    fs = require('fs'),
    cwd = fs.workingDirectory + '/test/',
    list = fs.list(cwd + 'visualTest/unprismed/');
    list = Array.prototype.slice.call(list);

function handle_page(file){
    page.open(cwd + 'visualTest/unprismed/'+ file, function (status) {
        if (status !== 'success'){

        } else {
            var html = page.evaluate(function(){
                return document.getElementsByTagName('html')[0].innerHTML
            });
            html = "<!DOCTYPE html>\n<html>" + html + "\n</html>";
            fs.write(cwd + 'visualTest/prismed-js/'+ file, html, 'w');
            setTimeout(next_page,100);
        }
    })
}

function next_page()
{
    var file = false;
    do {
        file = list.shift();
    } while (file === '.' || file === '..' || file === '.gitkeep');
    
    console.log(); 
    if (!file) {
        phantom.exit(0);
    }
    
    handle_page(file);
}

next_page();
//phantom.exit();
