#!C:\Program Files (x86)\Python37-32\python

#this will tell that we want to output something in html

print ('Content-type: text/html')
print ()

#if we want to use GET variable in python we need to import cgi

import cgi

#this allows us to use random various functions

import random

#this helps to acces POST and GET variables

form = cgi.FieldStorage()

# in the beginning we define reds and whites so for the start we want them begin 0
# reds are the correct digit(s) that are in the right place
# whites are the correct digit(s) that are in the wrong place
reds = 0
whites = 0

#this will check if there is a answer in form variable
if "answer" in form:
    
#so if there is a answer in form variable than get the "answer" value from the form
    
    answer = form.getvalue("answer")

# else if there is no answer in form variable, then leave create a new "asnwer" and leave it empty
else:
    answer = ""

# return 4 digits number
    for i in range(4):
# append to answer a random generated number from 0 to 9
        answer += str(random.randint(0, 9))       
        
# if there is a "guess" in form variable than get the "guess" value from the form. Else if there is no "guess" in form so leave the "guess" empty (line 53,54)

if "guess" in form:
    guess = form.getvalue("guess")

# When the built in enumerate() function is called on a list, it returns an object that can be iterated over, returning a count and the value returned from the list.
    for key, digit in enumerate(guess):
        if digit == answer[key]:
            reds += 1
        else:
            for answerDigit in answer:
                if answerDigit == digit:
                    whites += 1
                    break
        
else:
    guess = ""
    
# if "numberOfGuesses" in form so give "numberOfGuesses" a value and we gonna need it to be "int" because we gonna add + 1 to it else "numberOfGuesses" is 0
# so this means that everytime the user click guess this will add +1 to the number of guesses
    
if "numberOfGuesses" in form:
    numberOfGuesses = int(form.getvalue("numberOfGuesses")) + 1
else:
    numberOfGuesses = 0

# so here if the "numberOfGuesses" is 0 then message "I've chosen a 4 digit number. Can you guess it?", so basically "numberOfGuesses" is 0 only when the page starts so at the moment that we click "guess" button one time that the "numberOfGuesses" is not 0 anymore

if numberOfGuesses == 0:
    message = "I've chosen a 4 digit number. Can you guess it?"
    
#The elif keyword is used in conditional statements (if statements), and is short for else if.
#if the number of "reds" is equal to 4(we got all of the 4 numbers right) then message the success message
    
elif reds == 4:
    
    message = "Well done! You got in " + str(numberOfGuesses) + " guesses. <a href=''>Play again</a>"
    
# so if the "numberOfGuesses" is not 0 and the reds is not 4 than we message something else/ we message the reds(how many correct digit(s) we have in the right place) and the whites(how many correct digit(s) we have right but in the wrong place)
    
else:
    
    message = "You have " + str(reds) + " correct digit(s) in the right place, and " + str(whites) + " correct digit(s) in the wrong place. You have had " + str(numberOfGuesses) + " guess(es)."
    
print (answer) 
print (reds)

print ('<h1>Mastermind</h1>')
print ("<p>" + message + "</p>")
print ('<form method="post">')
print ('<input type="text" name="guess" value="' + guess + '">')
print ('<input type="hidden" name="answer" value = "' + answer + '">')
print ('<input type="hidden" name="numberOfGuesses" value = "' + str(numberOfGuesses) + '">')
print ('<input type="submit" value="Guess!">')
print ('</form>')