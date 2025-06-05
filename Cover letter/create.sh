
echo Hello, which copany are we targeting?
read company
echo and which role?
read role

echo 'Using company: '$company
echo 'Using role: '$role

# sed 's/_Job Title_/'$role'/' 
#      s/_Company Name_/'$company'/'' cover_template.txt > $company.txt

sed "s/_Job Title_/$role/
     s/_Company Name_/$company/" cover_template.txt > $company.txt