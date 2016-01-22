import os

def create_dir(dir):
	full_path = os.getcwd() + dir
	if(os.path.exists(full_path)):
		print "Path " + dir + " already exists!"
	else:
		print "create" + dir
		os.mkdir(full_path)

print "Initializing the project directory..."
create_dir('/Framework/public/avatar/')
create_dir('/Framework/public/file/')
create_dir('/Framework/public/student_card/')
create_dir('/Framework/public/upload/cache/')

