@echo off

rem -------------------------------------------------------------
rem  Yii command line bootstrap script for Windows.
rem  %cd%代表的是执行文件的当前目录，强调bat是在哪里启动的
rem  %~dp0代表的是bat文件所在的文件目录，强调bat的文件位置
rem  setlocal 之后所做的环境改动只限于批处理文件。要还原原先的设置，必须执行 endlocal
rem -------------------------------------------------------------

@setlocal

set YII_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%YII_PATH%yii" %*

@endlocal
