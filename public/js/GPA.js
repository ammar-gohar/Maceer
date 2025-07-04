let semesterCount = 0;

function addSemester(label) {
    semesterCount++;
    const semesterList = document.getElementById('semesterList');
    const semesterDiv = document.createElement('div');
    semesterDiv.className = 'semester';
    semesterDiv.id = `semester${semesterCount}`;
    semesterDiv.innerHTML = `
        <div class="mb-2 input-group">
            <label class="form-label m-2">${label} ${semesterCount}:</label>
            <input type="number" class="form-control" id="hours${semesterCount}" min="0">
            <button class="btn btn-outline-danger" type="button" onclick="removeSemester(${semesterCount})">
                <i class="bi bi-x"></i>
            </button>
        </div
    `;
    semesterList.appendChild(semesterDiv);
}

function removeSemester(id) {
    const semesterDiv = document.getElementById(`semester${id}`);
    semesterDiv.remove();
    semesterCount--;
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
        resultDiv.innerHTML = '<span class="text-danger mt-2">غير ممكن تحقيق الـ GPA المستهدف مع الساعات المتبقية!</span>';
        return;
    }
    if (requiredGpa < 0) {
        resultDiv.innerHTML = '<span class="text-danger mt-2">الـ GPA المستهدف أقل من الحالي، يرجى تعديل القيم!</span>';
        return;
    }

    // إنشاء جدول النتائج
    let table = `
        <table class="mt-2">
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
        <p class="mt-2">إجمالي الساعات: ${totalHours}</p>
        <p>الـ GPA المطلوب في الفصول المتبقية (على الأقل): <strong>${requiredGpa.toFixed(2)}</strong></p>
        ${table}
    `;
}
