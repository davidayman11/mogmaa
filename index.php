<?php include 'db.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <title>تسجيل</title>
    <style>
    body {
        margin: 0;
        font-family: "Segoe UI", "Tahoma", "Arial", sans-serif;
        background-color: #f4f6f8;
        color: #333;
        direction: rtl;
    }

    .main {
        margin-right: 220px;
        /* Changed from margin-left to margin-right */
        padding: 40px 30px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Heading */
    h1 {
        color: #0f766e;
        margin-bottom: 25px;
        font-size: 28px;
    }

    /* Form card */
    form {
        background: #ffffff;
        padding: 30px 35px;
        width: 100%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    form:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    /* Form groups */
    .nice-form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #0f766e;
        font-size: 15px;
    }

    /* Inputs and selects */
    input,
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: border 0.2s, box-shadow 0.2s;
        text-align: right;
        /* Align text to right for Arabic */
    }

    input:focus,
    select:focus {
        border-color: #0f766e;
        box-shadow: 0 0 6px rgba(15, 118, 110, 0.25);
        outline: none;
    }

    /* Submit button */
    input[type="submit"] {
        background-color: #0f766e;
        color: #fff;
        border: none;
        padding: 14px 20px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
    }

    input[type="submit"]:hover {
        background-color: #115e59;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main {
            margin-right: 0;
            /* Changed from margin-left to margin-right */
            padding: 20px 15px;
        }

        form {
            width: 100%;
            padding: 20px;
            margin: 0;
        }

        h1 {
            font-size: 24px;
            text-align: center;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidenav.php'; ?>

    <div class="main">
        <h1>التسجيل</h1>
        <form action="submit.php" method="post">
            <div class="nice-form-group">
                <label>الاسم</label>
                <input type="text" name="name" placeholder="ادخل الاسم الكامل" required />
            </div>
            <div class="nice-form-group">
                <label>رقم الهاتف</label>
                <input type="tel" name="phone" placeholder="+20XXXXXXXXXX" value="+2" required />
            </div>
            <div class="nice-form-group">
                <label>الفريق</label>
                <select name="team" id="team" required>
                    <option value="" disabled selected>اختر الفريق</option>
                    <option value="براعم">براعم</option>
                    <option value="أشبال">أشبال</option>
                    <option value="زهرات">زهرات</option>
                    <option value="كشافة">كشافة</option>
                    <option value="مرشدات">مرشدات</option>
                    <option value="متقدم">متقدم</option>
                    <option value="رائدات">رائدات</option>
                    <option value="جوالة">جوالة</option>
                    <option value="قادة">قادة</option>
                </select>
            </div>
            <div class="nice-form-group">
                <label>الصف الدراسي</label>
                <select name="grade" id="grade" required>
                    <option value="" disabled selected>اختر الصف الدراسي</option>
                </select>
            </div>
            <div class="nice-form-group">
                <label>المبلغ المدفوع</label>
                <input type="text" name="payment" placeholder="ادخل المبلغ المدفوع" required />
            </div>
            <input type="submit" value="إرسال">
        </form>
    </div>

</body>
<script>
document.getElementById('team').addEventListener('change', function() {
    const team = this.value;
    const gradeSelect = document.getElementById('grade');

    // Clear existing options
    gradeSelect.innerHTML = '<option value="" disabled selected>اختر الصف الدراسي</option>';

    let grades = [];


    switch (team) {
        case 'براعم':
            grades = [{
                    value: 'اولي_ابتدائي',
                    text: 'أولي ابتدائي'
                },
                {
                    value: 'ثانيه_ابتدائي',
                    text: 'ثانية ابتدائي'
                }
            ];
            break;
        case 'أشبال':
        case 'زهرات':
            grades = [{
                    value: 'تالته_ابتدائي',
                    text: 'ثالثة ابتدائي'
                },
                {
                    value: 'رابعه_ابتدائي',
                    text: 'رابعة ابتدائي'
                },
                {
                    value: 'خامسه_ابتدائي',
                    text: 'خامسة ابتدائي'
                },
                {
                    value: 'سادسه_ابتدائي',
                    text: 'سادسة ابتدائي'
                }
            ];
            break;
        case 'كشافة':
        case 'مرشدات':
            grades = [{
                    value: 'اولي_اعدادي',
                    text: 'أولي إعدادي'
                },
                {
                    value: 'ثانيه_اعدادي',
                    text: 'ثانية إعدادي'
                },
                {
                    value: 'تالته_اعدادي',
                    text: 'ثالثة إعدادي'
                }
            ];
            break;
        case 'متقدم':
        case 'رائدات':

            grades = [{
                    value: 'اولي_ثانوي',
                    text: 'أولي ثانوي'
                },
                {
                    value: 'ثانيه_ثانوي',
                    text: 'ثانية ثانوي'
                },
                {
                    value: 'تالته_ثانوي',
                    text: 'ثالثة ثانوي'
                }
            ];
            break;
            break;
        case 'متقدم':
        case 'رائدات':

            grades = [{
                    value: 'اولي_ثانوي',
                    text: 'أولي ثانوي'
                },
                {
                    value: 'ثانيه_ثانوي',
                    text: 'ثانية ثانوي'
                },
                {
                    value: 'ثالثة_ثانوي',
                    text: 'ثالثة ثانوي'
                }
            ];
            break;
        case 'جوالة':
            grades = [{
                    value: 'جامعة',
                    text: 'جامعة'
                },
                {
                    value: 'خريج',
                    text: 'خريج'
                }
            ];
            break;
        case 'قادة':
            grades = [{
                    value: 'جامعة',
                    text: 'جامعة'
                },
                {
                    value: 'خريج',
                    text: 'خريج'
                }
            ];
            break;

    }

    // Add grades to select
    grades.forEach(grade => {
        const option = document.createElement('option');
        option.value = grade.value;
        option.textContent = grade.text;
        gradeSelect.appendChild(option);
    });
});
</script>

</html>