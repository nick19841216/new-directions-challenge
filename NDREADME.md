# New Directions Engineering Challenge 

This project is written using a Slim 4 skeleton application

As you are aware this is not a production level project so the following assumptions will be made

-- there is no database for this project so I have made use of arrays for the test data. Assume that any use of this data normally would be made via queries to the database. I have stored an array of companies in the Company model and an array of applicants in the Applicant model

-- assume that the company is logged in and has their apiKey available. This would normally require credentials that would generate a new apiKey and store it along side the relevant company in the database. For the sake of this challenege the apiKeys are simply 'test' followed by a number corresponding to a company. You can change which company is "logged in" by adjusting the apiKey variable at the top of the applicants.js file. Obviously in a production environment the apiKey would never be stored as text in a js file, i've put it there simply for testing changing between companies and passing in unauthorised keys. The apiKeys are stored in the companies array in the Company model

-- I started looking into XSS as discussed with Alex in my interview and wanted to implement solutions to minimise the risk of the injection of malicious code, however I didn't want to take any longer getting this project back to you. Just know that I have been looking into it, and in a production environment this would be crucial given the nature of the business.

--as the cv template is the same for each applicant i am just returning the base 64 string from a static function. You are still required to have a valid apiKey to download the CV but it is not attached to each applicant. Again in a production environment this would not be the case.

I have commented throughout the project to describe what each part of the project is doing but here is a brief written explanation of the project

-- I have made a html file called applicants.html. The routes.php file defaults to rendering this file. The html file consists of a simple form that allows you to search on the 3 areas discussed in the project. Which ever apiKey is set in the applicants.js file will determine which companies data is searchable.

-- Upon clicking search there is an event listener attached to the button that then executes JS to grab all the information from the form and then fetch the API. The routes file has a group set up for an api to fetch the applicant information and an api to download the cv. prior to the fetch an api middleware file authenticates the request. You can test this by setting the apiKey to a value which doesn't exist in the companies array. The request will then fail and pop an error to say you are not authorised. successful authentication will result in the correct applicants being retrieved from the applicants array and then rendered on the page through the applicants.js file. The same approach applies for the cv download.

I hope this explains the project well enough. Of course if you have any questions please don't hesitate to reach out. I look forward to hearing from you.

I used composer to start an intance of this project locally http://localhost:8080/

