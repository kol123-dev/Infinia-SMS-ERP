<?php

// Create backup directory with timestamp
$backup_dir = 'backup_' . date('Y-m-d_H-i-s');
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// List of files to process (excluding module files and critical system files)
$files_to_process = [
    'database/migrations/2019_02_10_125119_create_sm_general_settings_table.php',
    'resources/views/backEnd/systemSettings/generalSettingsView.blade.php',
    'resources/views/backEnd/systemSettings/updateGeneralSettings.blade.php',
    'config/spondonit.php',
    'public/backEnd/assets/css/rtl/infix.css',
    'public/backEnd/assets/css/infix.css',
    'resources/views/themes/edulia/demo/about.json',
    'resources/views/themes/edulia/demo/footer_menu.json',
    'resources/views/themes/edulia/demo/privacy_policy.json',
    'resources/views/themes/edulia/demo/header_menu.json',
    'resources/json/test.json',
    'resources/json/translations.json',
    'resources/var/translations.json',
    'resources/var/translations_ar.json',
    'resources/var/translations_fr.json',
    'resources/var/translations_es.json',
    'resources/var/translations_pt.json',
    'resources/var/translations_ru.json',
    'resources/var/translations_tr.json',
    'resources/var/translations_zh.json',
    'resources/var/translations_de.json',
    'resources/var/translations_it.json',
    'resources/var/translations_ja.json',
    'resources/var/translations_ko.json',
    'resources/var/translations_vi.json',
    'resources/var/translations_th.json',
    'resources/var/translations_id.json',
    'resources/var/translations_hi.json',
    'resources/var/translations_bn.json',
    'resources/var/translations_ur.json',
    'resources/var/translations_fa.json',
    'resources/var/translations_he.json',
    'resources/var/translations_ar.json',
    'resources/var/translations_fr.json',
    'resources/var/translations_es.json',
    'resources/var/translations_pt.json',
    'resources/var/translations_ru.json',
    'resources/var/translations_tr.json',
    'resources/var/translations_zh.json',
    'resources/var/translations_de.json',
    'resources/var/translations_it.json',
    'resources/var/translations_ja.json',
    'resources/var/translations_ko.json',
    'resources/var/translations_vi.json',
    'resources/var/translations_th.json',
    'resources/var/translations_id.json',
    'resources/var/translations_hi.json',
    'resources/var/translations_bn.json',
    'resources/var/translations_ur.json',
    'resources/var/translations_fa.json',
    'resources/var/translations_he.json'
];

// Create restore script
$restore_script = "<?php\n\n";
$restore_script .= "// Restore script for backup: $backup_dir\n\n";
$restore_script .= "\$files = [\n";

// Process each file
foreach ($files_to_process as $file) {
    if (file_exists($file)) {
        // Create backup
        $backup_path = $backup_dir . '/' . str_replace('/', '_', $file);
        copy($file, $backup_path);
        
        // Read file content
        $content = file_get_contents($file);
        
        // Replace occurrences
        $content = str_replace('infixEdu', 'infinia', $content);
        $content = str_replace('infix', 'infinia', $content);
        
        // Write back to file
        file_put_contents($file, $content);
        
        // Add to restore script
        $restore_script .= "    '$file',\n";
        
        echo "Processed: $file\n";
    }
}

$restore_script .= "];\n\n";
$restore_script .= "foreach (\$files as \$file) {\n";
$restore_script .= "    \$backup_file = __DIR__ . '/' . str_replace('/', '_', \$file);\n";
$restore_script .= "    if (file_exists(\$backup_file)) {\n";
$restore_script .= "        copy(\$backup_file, \$file);\n";
$restore_script .= "        echo \"Restored: \$file\\n\";\n";
$restore_script .= "    }\n";
$restore_script .= "}\n";

// Write restore script
file_put_contents($backup_dir . '/restore.php', $restore_script);

echo "\nBackup created in: $backup_dir\n";
echo "To restore the files, run: php $backup_dir/restore.php\n"; 