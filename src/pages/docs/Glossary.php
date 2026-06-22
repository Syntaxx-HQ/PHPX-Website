<?php

function Glossary()
{
    $terms = [
        ['Component', 'A PHP function that returns JSX and renders to UI.'],
        ['Element', 'The lightweight description a component returns, created by Component::create.'],
        ['Reconciler node', 'A persistent node in the reconciler tree that mirrors an element and holds its state.'],
        ['Reconciliation', 'Diffing new output against the existing reconciler tree and patching the DOM.'],
        ['Hook', 'A function like useState that lets a component hold state or run effects.'],
        ['Hydration', 'Adopting server-rendered DOM on the client instead of rebuilding it.'],
        ['Isomorphic', 'Code that runs the same on the server and the client.'],
        ['Host element', 'A plain DOM element such as div or button, written with a lowercase tag.'],
        ['Seed state', 'The initial state the server embeds in the page for the client to read.'],
        ['Suspension', 'The signal useSuspenseData throws while its data is loading.'],
    ];

    return (
        <DocPage title="Glossary" description="Terms used throughout these docs.">
            <dl className="space-y-4">
                {array_map(fn($t) => (
                    <div>
                        <dt className="font-semibold text-slate-900">{$t[0]}</dt>
                        <dd className="text-slate-600">{$t[1]}</dd>
                    </div>
                ), $terms)}
            </dl>
        </DocPage>
    );
}
