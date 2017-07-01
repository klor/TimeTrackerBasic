# TimeTrackerBasic

TimeTrackerBasic helps you keep track of time from a DOS command-prompt or in your browser address bar on your Windows computer.
TimeTrackerBasic removes the need to manually keep track of what you are doing - and when the job started.
Data is stored in a plain text file, in CSV format for easy access.

After having logged entries for the week, you can either leave the timesheet as is, or you can manually transfer the values to a corporate time registration system. Answering questions like "Did I work for 1 or 2 hours on the EnormiCorp project?" and "What did I do last Monday" will now be easy to answer for those who do most of their work behind a workstation in a Windows environment.

## How it works

Enter lines for your timesheet in a Windows command-prompt, or in your browser address bar.
Each timesheet line logs the starting date time and your timesheet entry.
The timesheet lines are stored as CSV in a text file - one file per weeek ("2020w52.txt").

Each text file has:

* One line per timesheet entry.
* The first column is the time entry ("20201224-2359")
* The second column is the timesheet entry, they are usually wrapped in ""-quoets ("My first task @EnormiCorp").

To retrieve data, you can use [fgetcsv()](http://php.net/manual/en/function.fgetcsv.php).


## Usage

### Usage in CMD

1. Open a Windows command-prompt, and enter:
	`CD \phpfiles\TimeTrackerBasic`
2. You can now log your time usage by typing "t" in the command-prompt, followed by your timesheet entry - as in this example:
	`C:\phpfiles\TimeTrackerBasic>t My first task #EnormiCorp` (where t is shorthand for `t.bat`)
3. Output:
	20201224-2359,"My first task #EnormiCorp"

How special characters are handled for entries in the command-prompt:

* "-double-quotes are not supported
* '-single-quotes are supported
* #-hashmarks are supported

### Usage in browser

1. Open a browser
2. Type in your TimeTrackerBasic folder (http://localhost/TimeTrackerBasic/).
3. Now you can log time usage in the browser's address line.
For instance, to enter "My first task @EnormiCorp", you enter:
	http://localhost/TimeTrackerBasic/?My first task @EnormiCorp
4. Output:
	20201224-2359,"My first task @EnormiCorp"

How special characters are handled for browser-entries:

* '-single-quotes work out of the box
* "-double-quotes are escaped (\")
* #-hashmarks are not supported

### Usage in browser with shorthand

Make a shorthand that redirects the string to your TimeTrackerBasic path (e.g., http://localhost/TimeTrackerBasic/).

The steps to do this in Firefox are:

1. Bookmark your TimeTrackerBasic path (e.g., http://localhost/TimeTrackerBasic/)
2. Open Bookmarks and edit your bookmark:
    Name: `Timesheet Basic (keyword: t)`
    Location: `http://localhost/TimeTrackerBasic/?%s`
    Keyword: t

Now you can simply type "t" followed by a timesheet entry - as here:
`t My first task @EnormiCorp`


## Installation

Download the project and install it on your local computer. At run-time, TimeTrackerBasic will attept to create a folder in './timesheets' at run-time and store log files in this folder. Log files are named with year and week number ("2020w52.txt").


## Configuration

The following values can be configured (default values in parenthesis): folder name (./timesheets/), file_ext (txt) and timezone (Europe/Copenhagen).

## Hooks

TimeTrackerBasic support hooks that allow you to manipulate each timesheet line.
Hooks trigger when the first word in your timesheet entry matches a function name. 
For instance, "t Hello Kristoffer" will call hello() with "Kristoffer" as argument -- see `index.php` for details.

Another use of hooks is to create a hook that looks for tags (`@MyProject`) in your registrations - and uses these to look up project and activity IDs (for `@MyProject`) in an array or database.
This may come handy because project and activity IDs are often required when entering time in corporate time registration systems.

For security reasons, function calls made by hooks are only supported in the command-prompt - while not supported in the browser (allowing function calls from the url can lead to all kinds of security nightmares).

