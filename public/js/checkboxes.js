function checkAllCheckboxes(module, parentCheckbox) {
    const checkboxes = [...document.getElementsByClassName(`${module}-checkbox`)];
    if (parentCheckbox.checked){
        checkboxes.map((e) => {
            e.checked = true;
            e.dispatchEvent(new Event('change')); // This triggers Livewire to notice the change
        })
    } else {
        checkboxes.map((e) => {
            e.checked = false;
            e.dispatchEvent(new Event('change')); // This triggers Livewire to notice the change
        })
    }
}

function nestedCheckbox(module) {
    const checkboxes = [...document.getElementsByClassName(`${module}-checkbox`)];
    if (checkboxes.every((e) => {
        return e.checked;
    })) {
        console.log('yes');
        document.getElementById(`${module}-Permissions`).checked = true;
    } else {
        console.log('no');
        document.getElementById(`${module}-Permissions`).checked = false;
    }
}
