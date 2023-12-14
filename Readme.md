# K-Digital Training Information Security 3rd Assignment 3

### Overview

**Subject: 서버 내 취약점 공격 및 방어**

**Environment**

```
OS: Kali Linux 6.3.0(VMware)
Language: PHP, HTML
Server: Apache
DB: MySQL
Tools: 
```

1. Source Code Link<a href="#1-source-code-link"><sup>[1]</sup></a>

2. Implementation<a href="#2-implementation"><sup>[2]</sup></a>

3. Wrap Up<a href="#3-wrap-up"><sup>[3]</sup></a>

4. WIP<a href="#4-wip"><sup>[4]</sup></a>

5. Review<a href="#5-review"><sup>[5]</sup></a>

6. Ref Links<a href="#6-ref-links"><sup>[6]</sup></a>

---

#### 1. Source Code Link

[Link - KDT_IS3_Assignment2](https://github.com/ymiwm/KDT_IS3_Assignment3)

---

#### 2. Implementation

앞서 수행한 [Assignment2](https://github.com/ymiwm/KDT_IS3_Assignment2) Web Application의 취약점 분석

0. Assets(WIP)
    1. '*Member*' table account information
    3. Session hijacking
    2. Disguise when '*Write Post*'
    4. Sniffing data
    5. Directory and file information

1. SQL injection - **Failed**
    - **수행**: PDO로 인해 다른 injection 방법 수행  
    ```--secure-file-priv``` 설정을 ```null```로 바꾼 후 ```load_file()```을 이용해 *sqli.txt*을 불러오기 시도  
    ( + )```(select '<?=`$_GET[var]`;?>f' into outfile '/var/www/html/hack.php')```

    - **결과**: SQL injection 이전에 MySQL server에 직접 query를 보냈을 때 결과값이 null로 반환되어 파일 불러오기 실패
    ![SQL 0](/img/SQL_Injection/SQLI%200.png)

    - **방어**: PDO의 prepare(pstmt)과 parameter binding(bindParam) 사용과 필터링을 추가해주면 더 견고한 방어가 가능할 것으로 보임

2. Cross-Site Scripting(XSS) - **Succeed**
    - **수행**: *Write* 작업에서 보내지는 ```content``` 에 payload를 입력하여 결과 확인

    - **수행**: ```alert``` 동작, 서버 내 img파일에도 접근하여 출력 가능
    
    - ```<script> alert(1) </script>```
    ![XSS 0](/img/XSS/XSS%200.png)
    ![XSS 1](/img/XSS/XSS%201.png)
    - ```<img src='img/f.png'>```
    ![XSS 2](/img/XSS/XSS%202.png)
    ![XSS 3](/img/XSS/XSS%203.png)

    - **방어**: 시스템적인 방어가 불가능함으로 문자 필터링으로 방어

3. Session prediction & Session fixation - **Failed**
    - **수행**: ```<script>alert(document.cookie)</script>```를 *index.php*에 hard coding하여 확인

    - **결과**: 검색 결과 MD5 해쉬를  
        - IP address of the client
        - Current time
        - PHP Linear Congruence Generator - a pseudo random number generator (PRNG)
        - OS-specific random source - if the OS has a random source available (e.g. /dev/urandom)

    위와 같은 요소와 함께 생성한다고 함.
    이로써 Session prediction은 해결되었지만, 다른 시간에 로그아웃 후 로그인 해본 결과 ```session_destroy()```가 되어 id가 바뀔 것이라 예상하였으나 같은 id가 주어짐. 다만, 웹 브라우저를 껐다키는 경우 값이 바뀌어 Session fixation 또한 해당되지 않는 것으로 보임.

    - 로그인 후 
    ![SESSION 0](/img/session/Session%200.png)
    - 로그아웃 후 다시 로그인
    ![SESSION 1](/img/session/Session%201.png)
    - 웹 브라우저 종료 후 다시 로그인
    ![SESSION 2](/img/session/Session%202.png)

5. Insufficient authorization(WIP)
    - **수행**: *Write* 동작 시 *POST* 방식으로 보내지는 ```$id``` 값에서 session에 대한 검증이 없으므로 접근 권한을 무시하고 다른 작성자로 위장할 수 있음.

    - **결과**: 

6. Sending plain data(WIP)
    - **수행**:

    - **결과**:

7. Directory indexing & Directory traversal & Location identification(WIP)
    - **수행**: 
 
    - **결과**: 

---

#### 3. Wrap Up

1. Wrap UP
    - WIP

#### 4. WIP
- SQL injection을 수행하지 못해본 점이 아쉬움 -> 이후 source code 및 exploit 방법 교정 후 다시 시도

- 치명적인 공격이 가능한 XSS payload 찾기

- ```session_destroy()``` 이후 세션 id값이 바뀌지 않는 이유 확인

- Session hijacking 방식 찾기

- 인증(Authentification)과 인가(Authorization)의 차이 확인

- Hacking tool에 관해 정리(ex.*WireShark* VS *Burp Suite*)

- Directory 및 File 접근을 막기위한 방안 확인

- 방어 방법을 코드에 구현하여 결과 확인

---

#### 4. Review

- 피드백 후 추가 예정

---

#### 5. _Ref Links_

OWASP Top 10 

![OWASP TOP10 2017-2021](/img/OWASP/OWASP_TOP10_2017_2021.png)

1. A01:2021 - [Broken Access Control](https://owasp.org/Top10/A01_2021-Broken_Access_Control/)

2. A02:2021 - [Cryptographic Failures](https://owasp.org/Top10/A02_2021-Cryptographic_Failures/)

3. A03:2021 - [Injection](https://owasp.org/Top10/A03_2021-Injection/)

4. A04:2021 - [Insecure Design](https://owasp.org/Top10/A04_2021-Insecure_Design/)

5. A05:2021 - [Security Misconfiguration](https://owasp.org/Top10/A05_2021-Security_Misconfiguration/)

6. A06:2021 - [Vulnerable and Outdated Components](https://owasp.org/Top10/A06_2021-Vulnerable_and_Outdated_Components/)

7. A07:2021 - [Identification and Authentication Failures](https://owasp.org/Top10/A07_2021-Identification_and_Authentication_Failures/)

8. A08:2021 - [Software and Data Integrity Failures](https://owasp.org/Top10/A08_2021-Software_and_Data_Integrity_Failures/)

9. A09:2021 - [Security Logging and Monitoring Failures](https://owasp.org/Top10/A09_2021-Security_Logging_and_Monitoring_Failures/)

10. A10:2021 - [Server-Side Request Forgery](https://owasp.org/Top10/A10_2021-Server-Side_Request_Forgery_%28SSRF%29/)

---

[_Go to top_ ↑](#k-digital-training-information-security-3rd-assignment-3)