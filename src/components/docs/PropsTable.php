<?php

/** API reference table. rows: [[name, type, default, description], ...]. */
function PropsTable($props)
{
    $rows = $props['rows'] ?? [];
    return (
        <table data-testid="props-table">
            <thead>
                <tr><th>Name</th><th>Type</th><th>Default</th><th>Description</th></tr>
            </thead>
            <tbody>
                {array_map(fn($r) => (
                    <tr>
                        <td><code>{$r[0]}</code></td>
                        <td><code>{$r[1]}</code></td>
                        <td><code>{$r[2]}</code></td>
                        <td>{$r[3]}</td>
                    </tr>
                ), $rows)}
            </tbody>
        </table>
    );
}
