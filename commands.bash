 ssh-keygen -t rsa -b 4096 -C "contactkevenjuma@gmail,com"

 PS C:\Users\Admin\.ssh> # Generate a brand new RSA key in PEM format
PS C:\Users\Admin\.ssh> ssh-keygen -t rsa -b 4096 -m PEM -f "$env:USERPROFILE\.ssh\github_actions_key" -C "github-actions-deploy"
Generating public/private rsa key pair.
