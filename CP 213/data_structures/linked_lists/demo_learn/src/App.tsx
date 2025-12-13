import React, { useState, useCallback, useMemo } from 'react';
import LinkedListVisualization from './components/LinkedListVisualization';
import CodeEditor from './components/CodeEditor';
import ExplanationPanel from './components/ExplanationPanel';
import OperationButtons from './components/OperationButtons';
import ChallengePanel from './components/ChallengePanel';
import { ExecutionState, ListNode, Statement } from './types';
import { executeStatement, createNode, resetNodeIdCounter } from './utils/linkedListEngine';

const POINTER_COLORS = new Map([
  ['p', '#9B59B6'],
  ['q', '#E67E22'],
  ['newNode', '#1ABC9C'],
  ['temp', '#F39C12'],
  ['current', '#3498DB'],
]);

function App() {
  const [state, setState] = useState<ExecutionState>({
    head: null,
    pointers: new Map(),
    explanation: '',
    stepNumber: 0,
    hasLoop: false,
    lostNodes: new Set(),
  });

  const [allNodes, setAllNodes] = useState<Map<string, ListNode>>(new Map());
  const [currentExplanation, setCurrentExplanation] = useState('');
  const [currentError, setCurrentError] = useState<string | undefined>();
  const [currentWarning, setCurrentWarning] = useState<string | undefined>();
  const [score, setScore] = useState(0);
  const [currentChallenge, setCurrentChallenge] = useState<any>(null);

  const handleExecute = useCallback((statement: string) => {
    // Create a new map to ensure React detects the change
    const updatedNodes = new Map(allNodes);
    const result = executeStatement(statement, state, updatedNodes);
    
    setState(result.newState);
    setCurrentExplanation(result.explanation);
    setCurrentError(result.error);
    setCurrentWarning(undefined);
    setAllNodes(new Map(updatedNodes));

    // Scoring logic
    if (!result.error && !result.newState.hasLoop && result.newState.lostNodes.size === 0) {
      setScore(prev => prev + 10);
    } else if (result.error || result.newState.hasLoop || result.newState.lostNodes.size > 0) {
      setScore(prev => Math.max(0, prev - 5));
    }
  }, [state, allNodes]);

  const handleClear = useCallback(() => {
    resetNodeIdCounter();
    setState({
      head: null,
      pointers: new Map(),
      explanation: '',
      stepNumber: 0,
      hasLoop: false,
      lostNodes: new Set(),
    });
    setAllNodes(new Map());
    setCurrentExplanation('');
    setCurrentError(undefined);
    setCurrentWarning(undefined);
  }, []);

  const createList = useCallback(() => {
    const node1 = createNode(10);
    const node2 = createNode(20);
    const node3 = createNode(30);
    
    node1.link = node2;
    node2.link = node3;
    
    const nodes = new Map<string, ListNode>();
    nodes.set(node1.id, node1);
    nodes.set(node2.id, node2);
    nodes.set(node3.id, node3);
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
      head: node1,
    }));
    setCurrentExplanation('Created a linked list with nodes containing values 10, 20, and 30. Head points to the first node.');
  }, []);

  const insertBeginning = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Create a list first.');
      return;
    }

    const newNode = createNode(5);
    const nodes = new Map(allNodes);
    nodes.set(newNode.id, newNode);
    
    newNode.link = state.head;
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
      head: newNode,
    }));
    setCurrentExplanation('Inserted node with value 5 at the beginning. The new node\'s link points to the old head, and head now points to the new node.');
  }, [state.head, allNodes]);

  const insertEnd = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Create a list first.');
      return;
    }

    let current = state.head;
    while (current.link) {
      current = current.link;
    }

    const newNode = createNode(40);
    const nodes = new Map(allNodes);
    nodes.set(newNode.id, newNode);
    
    current.link = newNode;
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
    }));
    setCurrentExplanation('Inserted node with value 40 at the end. Traversed to the last node and set its link to the new node.');
  }, [state.head, allNodes]);

  const insertMiddle = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Create a list first.');
      return;
    }

    // Find middle node (second node if exists)
    let p = state.head;
    if (!p.link) {
      setCurrentError('List has only one node. Cannot insert in middle.');
      return;
    }

    const newNode = createNode(25);
    const nodes = new Map(allNodes);
    nodes.set(newNode.id, newNode);
    
    // Correct order: newNode->link = p->link, then p->link = newNode
    newNode.link = p.link;
    p.link = newNode;
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
    }));
    setCurrentExplanation('Inserted node with value 25 in the middle. First, newNode->link was set to preserve the remainder. Then p->link was updated to point to newNode. This is the CORRECT order.');
  }, [state.head, allNodes]);

  const demonstrateWrong = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Create a list first.');
      return;
    }

    let p = state.head;
    if (!p.link) {
      setCurrentError('List has only one node. Cannot demonstrate wrong insertion.');
      return;
    }

    const newNode = createNode(99);
    const nodes = new Map(allNodes);
    nodes.set(newNode.id, newNode);
    
    // WRONG ORDER: p->link = newNode first, then newNode->link = p->link
    // This creates a self-loop!
    p.link = newNode;
    newNode.link = p.link; // This is now newNode itself!
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
    }));
    setCurrentExplanation('DEMONSTRATION OF WRONG ORDER: First, p->link was set to newNode. Then newNode->link was set to p->link, which is now newNode itself! This creates a self-loop and loses the remainder of the list. This is why order matters!');
    setCurrentWarning('The list is now broken! The node that was after p is now lost and unreachable.');
  }, [state.head, allNodes]);

  const deleteNode = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Nothing to delete.');
      return;
    }

    // Delete first node
    const nodes = new Map(allNodes);
    const oldHead = state.head;
    nodes.delete(oldHead.id);
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
      head: oldHead.link,
    }));
    setCurrentExplanation(`Deleted the first node (value: ${oldHead.info}). Head now points to the second node, or NULL if the list is empty.`);
  }, [state.head, allNodes]);

  const traverse = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Nothing to traverse.');
      return;
    }

    const values: number[] = [];
    const visited = new Set<string>();
    let current: ListNode | null = state.head;
    
    while (current && !visited.has(current.id)) {
      visited.add(current.id);
      if (current.info !== null) {
        values.push(current.info);
      }
      current = current.link;
    }

    if (visited.size < allNodes.size) {
      setCurrentWarning('Loop detected during traversal! Some nodes were not visited.');
    }

    setCurrentExplanation(`Traversed the list. Visited nodes with values: ${values.join(' -> ')}${current ? ' (loop detected!)' : ''}`);
  }, [state.head, allNodes]);

  const search = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Nothing to search.');
      return;
    }

    const searchValue = 20; // Example search value
    let current: ListNode | null = state.head;
    let found = false;
    const visited = new Set<string>();

    while (current && !visited.has(current.id)) {
      visited.add(current.id);
      if (current.info === searchValue) {
        found = true;
        break;
      }
      current = current.link;
    }

    setCurrentExplanation(found 
      ? `Found node with value ${searchValue} in the list.`
      : `Value ${searchValue} not found in the list.`
    );
  }, [state.head]);

  const handleStartChallenge = useCallback((challenge: any) => {
    setCurrentChallenge(challenge);
    handleClear();
    createList();
    setCurrentExplanation(`Challenge started: ${challenge.title}. ${challenge.description}`);
  }, [handleClear, createList]);

  return (
    <div style={{ 
      maxWidth: '1400px', 
      margin: '0 auto', 
      padding: '20px',
      minHeight: '100vh'
    }}>
      <header style={{ 
        textAlign: 'center', 
        marginBottom: '30px',
        color: 'white'
      }}>
        <h1 style={{ fontSize: '36px', marginBottom: '10px', textShadow: '2px 2px 4px rgba(0,0,0,0.3)' }}>
          Linked List Visualizer
        </h1>
        <p style={{ fontSize: '18px', opacity: 0.9 }}>
          Interactive Educational Game - Learn Pointers at the Memory Level
        </p>
      </header>

      <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
        <div>
          <ChallengePanel
            currentChallenge={currentChallenge}
            onStartChallenge={handleStartChallenge}
            score={score}
          />
          
          <OperationButtons
            onCreateList={createList}
            onInsertBeginning={insertBeginning}
            onInsertEnd={insertEnd}
            onInsertMiddle={insertMiddle}
            onDelete={deleteNode}
            onTraverse={traverse}
            onSearch={search}
            onDemonstrateWrong={demonstrateWrong}
          />
        </div>

        <div>
          <CodeEditor
            onExecute={handleExecute}
            onClear={handleClear}
          />
          
          <ExplanationPanel
            explanation={currentExplanation}
            error={currentError}
            warning={currentWarning}
          />
        </div>
      </div>

      <LinkedListVisualization
        state={state}
        allNodes={allNodes}
        pointerColors={POINTER_COLORS}
      />

      <footer style={{ 
        textAlign: 'center', 
        marginTop: '40px', 
        padding: '20px',
        color: 'white',
        opacity: 0.8
      }}>
        <p>Step {state.stepNumber} | Nodes: {allNodes.size} | Lost Nodes: {state.lostNodes.size}</p>
      </footer>
    </div>
  );
}

export default App;

