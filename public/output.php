ErrorException: Undefined array key "REQUEST_METHOD" in D:\Projets\mvc-boilerplate\src\Http\Router.php:22
Stack trace:
#0 D:\Projets\mvc-boilerplate\vendor\tracy\tracy\src\Tracy\Debugger\Debugger.php(380): Tracy\DevelopmentStrategy->handleError(2, 'Undefined array...', 'D:\\Projets\\mvc-...', 22, NULL)
#1 D:\Projets\mvc-boilerplate\src\Http\Router.php(22): Tracy\Debugger::errorHandler(2, 'Undefined array...', 'D:\\Projets\\mvc-...', 22)
#2 D:\Projets\mvc-boilerplate\public\index.php(14): App\Http\Router::run()
#3 {main}
Tracy is unable to log error: Logging directory is not specified.
