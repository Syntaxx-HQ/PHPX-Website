<?php

function FocusCaret()
{
    return (
        <DocPage title="Focus and Caret Retention" description="Why your inputs behave.">
            <p>
                When state changes, PHPX re-renders and patches the DOM. Around that patch it saves and
                restores the active element and its selection, so the caret in a text field or a
                contentEditable region lands back exactly where it was.
            </p>

            <Heading level={2} id="preserved">What is preserved</Heading>
            <ul>
                <li>Which element has focus.</li>
                <li>The selection range in inputs and textareas.</li>
                <li>The caret position in contentEditable regions.</li>
            </ul>
            <LiveExample title="Type freely — focus stays">
                <TextEchoExample />
            </LiveExample>

            <Callout type="tip" title="No workarounds needed">
                You do not need refs, debouncing, or uncontrolled inputs to keep focus. Controlled
                inputs simply work.
            </Callout>
        </DocPage>
    );
}
