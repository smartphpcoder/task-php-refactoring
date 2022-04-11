# PHP Refactoring Task
Hello. Thank you for giving the opportunity to work on the task. It was fascinating, and I would be happy I have
more time to work on it and make it more readable and elegant as much as possible. I worked on it after the working hours,
so spent a couple of hours, but I see it's not enough.

I know I left couple of tests for the calculations as well as some things that should be taken care off.

# Installation
1. Clone the project using the https url below

```bash
https://github.com/smartphpcoder/QuoteQuizApp.git
```

2. Run composer install
```bash
composer install
```

3. Test the application for the input data provided in input.txt file.
```bash
php app.php input.txt
```

![Calculate Commission Results](/images/calculate_commission_results.png)

4. There is only one test which check whether the input data is parsed and returned correctly. To run the test,
see code below.
```bash
php vendor/bin/phpunit tests/CalculateCommissionTest.php --color
```

![Test Results](/images/test_result.png)