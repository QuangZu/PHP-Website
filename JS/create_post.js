
function setPostType(type) {
    document.getElementById('postType').value = type;
    document.getElementById('textTextarea').classList.toggle('hidden', type !== 'text');
    document.getElementById('imageTextarea').classList.toggle('hidden', type !== 'image');
    document.getElementById('linkTextarea').classList.toggle('hidden', type !== 'link');
}

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

document.getElementById('textOption').addEventListener('click', function () {
    setPostType('text');
});
document.getElementById('imageOption').addEventListener('click', function () {
    setPostType('image');
});
document.getElementById('linkOption').addEventListener('click', function () {
    setPostType('link');
});

document.getElementById('moduleButton').addEventListener('click', async function () {
    try {
        const response = await fetch('get_modules.php');
        if (!response.ok) throw new Error('Failed to fetch modules');
        const modules = await response.json();

        const moduleList = document.getElementById('moduleList');
        moduleList.innerHTML = '';

        modules.forEach(module => {
            const moduleItem = document.createElement('button');
            moduleItem.className = 'block w-full text-left p-2 hover:bg-gray-100';
            moduleItem.textContent = module.module_name;
            moduleItem.onclick = (event) => {
                event.preventDefault();
                selectModule(module.module_name, module.module_id);
            };
            moduleList.appendChild(moduleItem);
        });
        document.getElementById('moduleModal').classList.remove('hidden');
    } catch (error) {
        console.error(error);
    }
});

document.getElementById('closeModal').addEventListener('click', function () {
    document.getElementById('moduleModal').classList.add('hidden');
});

function selectModule(moduleName, moduleId) {
    document.getElementById('selectedModule').textContent = moduleName;
    document.getElementById('selectedModuleId').value = moduleId;
    document.getElementById('moduleModal').classList.add('hidden');
}
