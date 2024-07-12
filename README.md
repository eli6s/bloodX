# bloodX
Developed by a classmate and I, bloodX is a fully functioning blood bank webapp, which served as our final project for BT3. The comprehensive list of setup 
 instructions below can also be found on page 27 in the [report](report.pdf).

## Prerequisites
- WampServer 3.3.x
- C++ Redestributable (2005 - present)

## Installation instructions
1. Download and install WampServer on your machine:
   \
   https://www.wampserver.com/en/download-wampserver-64bits/

3. Download and install all versions of the C++ Redistributable:
   \
   https://learn.microsoft.com/en-us/cpp/windows/latest-supported-vc-redist?view=msvc-170

4. Clone one of the repositories:
   ```
   git clone https://github.com/MohammadRajha-SD/bloodX.git
   git clone https://github.com/eli6s/bloodX.git
   ```

## Setup instructions
1. Open up your web browser and navigate to phpMyAdmin:
   \
   http://localhost/phpmyadmin/

3. Create a database called blood_bank:
   ```sql
   CREATE DATABASE IF NOT EXISTS blood_bank;
   ```

4. You're all set! start using bloodX:
   \
   http://localhost/bloodX

6. To login as an admin:
   \
   username -> `admin`
   \
   password -> `admin12`
