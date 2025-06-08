let semesterCount = 0;

function addSemester() {
    if (semesterCount > 0) {
        // Get the button of the son of the semsterDiv
        const removeSemesterButton = document.getElementById(`semester${semesterCount}`).querySelector('button');
        removeSemesterButton.remove();
    }
    semesterCount++;
    const semesterList = document.getElementById('semesterList');
    const semesterDiv = document.createElement('div');
    semesterDiv.className = 'semester';
    semesterDiv.id = `semester${semesterCount}`;
    semesterDiv.innerHTML = `
        <label>عدد ساعات الترم ${semesterCount}:</label>
        <input type="number" id="hours${semesterCount}" min="0" placeholder="مثال: 15">
        <button onclick="removeSemester(${semesterCount})">حذف</button>
    `;
    semesterList.appendChild(semesterDiv);
}

function removeSemester(id) {
    const semesterDiv = document.getElementById(`semester${id}`);
    semesterDiv.remove();
    semesterCount--;
    const removeSemesterButton = document.getElementById(`semester${semesterCount}`).innerHTML += `<button onclick=\"removeSemester(${semesterCount})\">حذف</button>`;
}

function calculateGpa() {
    const currentGpa = parseFloat(document.getElementById('currentGpa').value);
    const currentHours = parseInt(document.getElementById('currentHours').value);
    const targetGpa = parseFloat(document.getElementById('targetGpa').value);
    const resultDiv = document.getElementById('result');

    // جمع ساعات الفصول المتبقية
    let remainingHours = 0;
    const semesterHours = [];
    for (let i = 1; i <= semesterCount; i++) {
        const hoursInput = document.getElementById(`hours${i}`);
        if (hoursInput) {
            const hours = parseInt(hoursInput.value);
            if (!isNaN(hours) && hours >= 0) {
                remainingHours += hours;
                semesterHours.push({ id: i, hours });
            }
        }
    }

    // التحقق من صحة المدخلات
    if (isNaN(currentGpa) || isNaN(currentHours) || isNaN(targetGpa) || remainingHours === 0) {
        resultDiv.innerHTML = '<span class="error">يرجى إدخال جميع القيم بشكل صحيح وإضافة ترم واحد على الأقل</span>';
        return;
    }
    if (currentGpa < 0 || currentGpa > 4 || targetGpa < 0 || targetGpa > 4) {
        resultDiv.innerHTML = '<span class="error">الـ GPA يجب أن يكون بين 0 و 4</span>';
        return;
    }
    if (currentHours < 0) {
        resultDiv.innerHTML = '<span class="error">عدد الساعات الحالية يجب أن يكون صحيحًا</span>';
        return;
    }

    // حساب النقاط
    const currentPoints = currentGpa * currentHours;
    const totalHours = currentHours + remainingHours;
    const targetPoints = targetGpa * totalHours;
    const requiredPoints = targetPoints - currentPoints;
    const requiredGpa = requiredPoints / remainingHours;

    // التحقق من إمكانية تحقيق الهدف
    if (requiredGpa > 4) {
        resultDiv.innerHTML = '<span class="error">غير ممكن تحقيق الـ GPA المستهدف مع الساعات المتبقية!</span>';
        return;
    }
    if (requiredGpa < 0) {
        resultDiv.innerHTML = '<span class="error">الـ GPA المستهدف أقل من الحالي، يرجى تعديل القيم!</span>';
        return;
    }

    // إنشاء جدول النتائج
    let table = `
        <table>
            <tr>
                <th>الترم</th>
                <th>عدد الساعات</th>
                <th>الـ GPA المطلوب (على الأقل)</th>
            </tr>
    `;
    semesterHours.forEach(semester => {
        table += `
            <tr>
                <td>الترم ${semester.id}</td>
                <td>${semester.hours}</td>
                <td>${requiredGpa.toFixed(2)}</td>
            </tr>
        `;
    });
    table += '</table>';

    resultDiv.innerHTML = `
        <p>إجمالي الساعات: ${totalHours}</p>
        <p>الـ GPA المطلوب في الفصول المتبقية (على الأقل): <strong>${requiredGpa.toFixed(2)}</strong></p>
        ${table}
    `;
}

// إضافة ترم افتراضي عند تحميل الصفحة
addSemester();