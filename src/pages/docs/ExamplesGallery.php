<?php

function ExamplesGallery()
{
    return (
        <DocPage title="Examples Gallery" description="Live, runnable examples for the core features.">
            <p>Each example below is a real PHPX component, server-rendered then hydrated. Interact with them.</p>
            <LiveExample title="Counter - useState">
                <CounterExample />
            </LiveExample>
            <LiveExample title="Toggle">
                <ToggleExample />
            </LiveExample>
            <LiveExample title="Controlled input">
                <TextEchoExample />
            </LiveExample>
            <LiveExample title="List">
                <ListExample />
            </LiveExample>
            <LiveExample title="Timer - useEffect">
                <TimerExample />
            </LiveExample>
            <LiveExample title="Todo">
                <TodoExample />
            </LiveExample>
            <LiveExample title="Data fetching - useData">
                <UseDataExample />
            </LiveExample>
            <LiveExample title="Suspense">
                <SuspenseExample />
            </LiveExample>
            <LiveExample title="Two independent counters">
                <TwoCountersExample />
            </LiveExample>
        </DocPage>
    );
}
