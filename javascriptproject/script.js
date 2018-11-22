// Date is a class/object and getTime is a fuction of this class
//qisaj variable ja kena lon emrin start edhe ja kena thon vleren " new Date().getTime(); " new osht komand qe e aktivizon ni objekt n ket rast Date().getTime();  
//we declared a variable named "start" by using var, then we initialize the function "date()" by using "new" and we used it's method "getTime()" to get the current time

var start = new Date().getTime();

// this is the function that generates a random color for the shape
            
            function getRandomColor() {
                
// "0123456789ABCDEF" are the components that generate the hash code colors, the function "spilt()" is aplied on these strings and splits them with single qoutes('') and all this is asigned to the variable letters, "spilt()" splits a string into an array
                
                
                
                var letters = '0123456789ABCDEF'.split('');
                
                var color = '#';
                
// "for" osht funksion qe perseritet qe pranon parametra, n ket rast "i" osht variabel me vler 0, i < 6 osht parameter qe e lejon qet funksion mu egzekutu derisa "i" osht ma e vogel se 6, n momentin qe bohet 6 ose ma e madhe funksioni ndalon ose nuk egzekutohet, "i++" e rrit vleren e "i" per 1 (+ 1) persecilin cikel te funksionit "for"
                
// "for" is a loop type function that accepts certain parameters, in this case "i" is a variable with a value of 0, "i < 6"   is a parameter that allows that this function to execute while "i"  is smaller than 6, at the time that "i" increases to a value of 6 or higher the function stops, "i++" incriments the value of "i" per fixed value of 1, for each iteration of function/loop "for".
                
                for (var i = 0; i < 6; i++ )  {
                    
// "Math.random" generates a random number between 0 and 1, and and we multiply that random value with 16, to get a value/random number in the range of 0-16 but as a decimal value(ex. 13.3) and this creates a problem because we need integer(whole numbers), and "Math.floor" solves this problem.
                    
// "Math.floor" converts a decimal number to an integer(whole nubmer) (ex.13.3 = 13, ) "Math.floor" takes the lower value (whole number) of 13.3 which is 13 , while "Math.ceil" takes the higher value 13.3 which is 14
                    
                    var randomNumber = Math.random() *16;
                    
//letter["index"] within the square brackets is the value of the index number that refeers to a value/element in the vector array of letters, this element in the letters vector array is appended to the color variable
// the "+=" opperator appends a value to the value that already exist
// this proccess interates 6 times based on the parameters on the "for" loop until a hashcode is completed                    

                    
                    color += letters[Math.floor(randomNumber)]
                    
                }
                
//after 6 iterations of the "for" loop the color hashcode is returned
                
                return color;
            }
                
// this is connected with (1/2) 
// this function makes the shape appear

            function makeShapeAppear() {
                
// we named the variable "top", "top" is the upper part of the "div", and we gave a random value from 0 to 400, which will be used for pixels.
                
                var top = Math.random() * 400;
                
// we named the variable "left", "left" is the left part of the "div", and we gave a random value from 0 to 900, which will be used for pixels.
                
                var left = Math.random() * 900;
                
//the width of the shape, from 0 to 200 but always add + 100 which means  the shabe will be between 100 and 300 px
                
                var width = (Math.random() * 200) + 100;
                
// this will make the shape circle half of the time 
                
                if (Math.random() > 0.5) {
                    
// in this document, (which "document" is an object that represents the html document loaded on the broswer) in this document we get the element by id(.getElementById) named shape, and we apply styles to it, in this case we applied a borderRadius style of 50% border raduis.
                    
                    document.getElementById("shape").style.borderRadius = "50%";
                    
                } else {
                    
// in this document, (which "document" is an object that represents the html document loaded on the broswer) in this document we get the element by id(.getElementById) named shape, and we apply styles to it, in this case we applied a borderRadius style of 0% border raduis.
                    
                    document.getElementById("shape").style.borderRadius = "0";
                    
                }
                
// we get the element by id named shape adn we apply to it backgroundcolor style, we get the backgroundColor value from the function we created earlier "getRandomColor"
                
                document.getElementById("shape").style.backgroundColor = getRandomColor();
                
//we get the elemend by id named shape and we apply to it width style, we get the width from the variable we created earilier "var width = (Math.random() * 200) + 100;" and we added the string "px" to the value width so css can interpret it as a pixel value
                
                document.getElementById("shape").style.width = width + "px";
                
                document.getElementById("shape").style.height = width + "px";
                
// (1/2)
                
                document.getElementById("shape").style.top = top + "px";
                
                document.getElementById("shape").style.left = left + "px";
            
                
// this'll reveal the shape again
// Displays an element as a block element (like <p>). It starts on a new line, and takes up the whole width                

                
                document.getElementById("shape").style.display = "block";
                
// this will measure the time when the page reloads until the first click
                
                start = new Date().getTime();
                
            }

// when you click the shape and it disappears this function will make it appear again after 0 to 2 seconds 
// this is a function named apperAfterDelay. will make shape appar between 0 and 2 seconds
            
            function appearAfterDelay() {
                
// setTimeout(function, milliseconds) Executes a function, after waiting a specified number of milliseconds.
                
                setTimeout(makeShapeAppear, Math.random() * 2000);
                
            }
            
//this will make shape appear over and over 1/1

            appearAfterDelay();

//this is a function which makes the shape disappear when you click
//we get the element by id named shape and we apply to it display style, we set the display to none which make the shape disappear after it's clicked 
            
            document.getElementById("shape").onclick = function() {
                
                document.getElementById("shape").style.display = "none";
                
// this will measure the time between clicks//
// we take the varidable named "timeTaken" and we give it a function "(end - start) / 1000;",  this will measure the time between clicks and we devide it by 1000 to convert from milliseconds to seconds
                
                var end = new Date().getTime();
                
                var timeTaken = (end - start) / 1000;
                
// this is connected with span in html which means this will show the time measured
// "innerHTML" inserts the value of "timeTaken" in the span with id="timeTaken"
                
                document.getElementById("timeTaken").innerHTML = timeTaken + "s";
                
//this will make shape appear over and over 1/2
                
                appearAfterDelay();
            }