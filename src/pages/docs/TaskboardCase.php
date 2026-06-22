<?php

function TaskboardCase()
{
    return (
        <DocPage title="Case Study: TaskBoard" description="A real Kanban app built with PHPX.">
            <p>
                TaskBoard is a Trello-style Kanban board built entirely with PHPX. It exercises the
                framework the way a real app does: nested components, keyed lists, drag and drop, a
                modal, inline editing, and a fair amount of state.
            </p>

            <Heading level={2} id="state">State shape</Heading>
            <p>
                The board holds its columns and cards in a single piece of state. Adding, deleting,
                moving, and editing a card are all functional updates to that state.
            </p>

            <Heading level={2} id="focus">Why focus matters</Heading>
            <p>
                Inline card editing is where the reconciler earns its keep. Double-clicking a card
                title swaps it for an input, and typing keeps the caret on every keystroke, even as the
                surrounding board re-renders.
            </p>

            <Heading level={2} id="lessons">Lessons</Heading>
            <ul>
                <li>Keep state in one place and derive the rest.</li>
                <li>Give every card a stable key.</li>
                <li>Use onInput for live editing so focus is preserved.</li>
            </ul>

            <Callout type="tip" title="Read the source">
                The TaskBoard repository is a good reference for structuring a non-trivial PHPX app.
            </Callout>
        </DocPage>
    );
}
