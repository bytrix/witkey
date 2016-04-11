import os
import sys

paths = [
	'/Framework/public/avatar/',
	'/Framework/public/file/',
	'/Framework/public/student_card/',
	'/Framework/public/upload/cache/',
	'/Server/db_backup/',
]

def create_dir(dir):
	full_path = os.getcwd() + dir
	if(os.path.exists(full_path)):
		print "\033[7;40;31mPath " + dir + " already exists!\033[0m"
	else:
		print "\033[1;32;40m  Creating directory\t" + dir + "\033[0m"
		os.mkdir(full_path)

def chmod_dir(dir):
	full_path = os.getcwd() + dir
	if(os.path.exists(full_path)):
		print "\033[1;33;40m  Changing mode of directory\t" + dir + "\033[0m"
		os.system('chmod o+w ' + full_path)
	else:
		print "\033[7;40;31mPath " + dir + " does not exists!\033[0m"

def remove_dir(dir):
	full_path = os.getcwd() + dir
	if(os.path.exists(full_path)):
		os.system('rm -r ' + full_path)
		print "\033[1;31;40m  Path\t" + dir + "removed\033[0m"
	else:
		print "\033[7;31;40mPath " + dir + "does not exists!\033[0m"

def view_dir(dir):
	full_path = os.getcwd() + dir
	if(os.path.exists(full_path)):
		dstat = os.stat(full_path)
		mode = oct(dstat.st_mode)[-3:]
		print "[\033[1;33;40m" + mode + "\033[0m] [\033[1;32;40mFOUND\033[0m] " + dir
	else:
		print "[\033[1;33;40m---\033[0m] [\033[1;31;40mNOT FOUND\033[0m] " + dir


if len(sys.argv) != 2:
	print 'This script is used to operate directories for the project automatically, the operation arguments are as below:'
	print '\t\033[1;32;40mcreate\033[0m'
	print '\t\tcreate directories:'
	for p in paths:
		print "\t\t    " + p

	print '\t\033[1;32;40mremove\033[0m'
	print '\t\tremove the directories'

	print '\t\033[1;32;40mchmod\033[0m'
	print '\t\tchange the mode of directories so that they can be writed by server program'

	print '\t\033[1;32;40mview\033[0m'
	print '\t\tview the status of directories'
else:
	print '-'*43
	print "| Initializing the project directories... |"
	print '-'*43
	if sys.argv[1] == 'create':
		for p in paths:
			create_dir(p)

	if sys.argv[1] == 'remove':
		for p in paths:
			remove_dir(p)

	if sys.argv[1] == 'chmod':
		for p in paths:
			chmod_dir(p)

	if sys.argv[1] == 'view':
		for p in paths:
			view_dir(p)