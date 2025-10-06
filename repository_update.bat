@echo off
setlocal enabledelayedexpansion

:: Configurable variables
set "REPO_URL=https://github.com/bugfishtm/bugfish-framework"
set "BRANCH=main"
set "INITIAL_COMMIT_MSG=Initial commit"

:: Cool Output Messages
echo ==============================
echo Welcome to the Bugfish Git Update Script!
echo ==============================
echo This script will help you:
echo 1. Stage all changes
echo 2. Commit with a message of your choice
echo 3. Push the commit to the branch you specify
echo ==============================

:: Confirm before proceeding
set /p "confirm=Are you sure you want to proceed? (y/n): "
if /i not "!confirm!"=="y" (
    echo Operation cancelled.
    pause
    exit /b 1
)

:: Ask for commit message for this update (cannot be empty)
:commitmsg
set /p "commitMsg=Enter your commit message: "
if "!commitMsg!"=="" (
    echo Commit message cannot be empty.
    goto commitmsg
)

:: Cool message before starting the Git commands
echo ==============================
echo Staging all files...
echo ==============================

:: Stage all files except batch script itself (optional: modify if you want to exclude)
git add .

:: Commit with user input message
echo ==============================
echo Committing with message: "!commitMsg!"
echo ==============================
git commit -m "!commitMsg!"

:: Add remote origin (only if not already added)
git remote get-url origin >nul 2>&1
if errorlevel 1 (
    git remote add origin %REPO_URL%
)

:: Push to specified branch
echo ==============================
echo Pushing to branch: %BRANCH%
echo ==============================
git push -u origin %BRANCH%

:: Completion message
echo ==============================
echo All done! Your changes have been pushed to the repository.
echo ==============================
pause

endlocal
