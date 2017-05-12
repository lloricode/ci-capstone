<?php

defined('BASEPATH') or exit('Direct Script is not allowed');



$subject_id = array(
    'name'  => "data[$index_iputs][subject]",
    'value' => $_dropdown_for_subjects,
    'type'  => 'dropdown',
    'lang'  => 'curriculum_subject_subject_label',
        // 'note'  => 'Requisites is on the next form after submit this current form.'
);

$curriculum_subject_year_level = array(
    'name'  => "data[$index_iputs][level]",
    'value' => _numbers_for_drop_down(1, 4),
    'type'  => 'dropdown',
    'lang'  => 'curriculum_subject_year_level_label',
);

$curriculum_subject_semester = array(
    'name'  => "data[$index_iputs][semester]",
    'value' => semesters(FALSE),
    'type'  => 'dropdown',
    'lang'  => 'curriculum_subject_semester_label'
);


if ($type === 'major')
{
        $curriculum_subject_lecture_hours = array(
            'name'  => "data[$index_iputs][lecture]",
            'value' => _numbers_for_drop_down($index_iputs, 5),
            'type'  => 'dropdown',
            'lang'  => 'curriculum_subject_lecture_hours_label'
        );

        $curriculum_subject_laboratory_hours = array(
            'name'  => "data[$index_iputs][laboratory]",
            'value' => _numbers_for_drop_down($index_iputs, 9),
            'type'  => 'dropdown',
            'lang'  => 'curriculum_subject_laboratory_hours_label'
        );

        $curriculum_subject_units = array(
            'name'  => "data[$index_iputs][units]",
            'value' => _numbers_for_drop_down(1, 6),
            'type'  => 'dropdown',
            'lang'  => 'curriculum_subject_units_label'
        );
}


echo input_bootstrap($subject_id, FALSE, FALSE);
echo input_bootstrap($curriculum_subject_year_level, FALSE, FALSE);
echo input_bootstrap($curriculum_subject_semester, FALSE, FALSE);

if (isset($curriculum_subject_lecture_hours) &&
        isset($curriculum_subject_laboratory_hours) &&
        isset($curriculum_subject_units))
{
        echo input_bootstrap($curriculum_subject_lecture_hours, FALSE, FALSE);
        echo input_bootstrap($curriculum_subject_laboratory_hours, FALSE, FALSE);
        echo input_bootstrap($curriculum_subject_units, FALSE, FALSE);
}