(function () {
    'use strict';

    let appTasks = {
        initEditTaskForm: function (task) {
            let fields = ['title', 'due_date', 'priority_id'];
            let editForm = document.forms.editTaskForm;
            fields.forEach(field => {
                let input = editForm.elements[field];
                if (input) {
                    input.value = task[field];
                }
            });
            editForm.setAttribute('action', editForm.getAttribute('action').split('tasks/')[0] + 'tasks/' + task.id);
        }
    };
    window.appTasks = appTasks;

})();