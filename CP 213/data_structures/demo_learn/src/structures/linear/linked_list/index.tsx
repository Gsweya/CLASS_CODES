import React, { useState, useCallback } from 'react';
import { DataStructure } from '../../base/StructureInterface';
import { GuideContent } from '../../base/types';
import LinkedListVisualization from '../../../components/linked_list/LinkedListVisualization';
import CodeEditor from '../../../components/linked_list/CodeEditor';
import ExplanationPanel from '../../../components/linked_list/ExplanationPanel';
import OperationButtons from '../../../components/linked_list/OperationButtons';
import ChallengePanel from '../../../components/linked_list/ChallengePanel';
import TraversalGuide from '../../../components/linked_list/TraversalGuide';
import CppInfoPanel from '../../../components/linked_list/CppInfoPanel';
import NotesPanel from '../../../components/linked_list/NotesPanel';
import Icon from '../../../components/shared/Icon';
import { ExecutionState, ListNode } from './types';
import { executeStatement, createNode, resetNodeIdCounter } from './utils/linkedListEngine';

const POINTER_COLORS = new Map([
  ['p', '#9B59B6'],
  ['q', '#E67E22'],
  ['newNode', '#1ABC9C'],
  ['temp', '#F39C12'],
  ['current', '#3498DB'],
]);

const LinkedListComponent: React.FC = () => {
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
  const [operationCode, setOperationCode] = useState<string>('');
  const [operationDescription, setOperationDescription] = useState<string>('');

  const handleExecute = useCallback((statement: string) => {
    const updatedNodes = new Map(allNodes);
    const result = executeStatement(statement, state, updatedNodes);
    
    setState(result.newState);
    setCurrentExplanation(result.explanation);
    setCurrentError(result.error);
    setCurrentWarning(undefined);
    setAllNodes(new Map(updatedNodes));

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
    setOperationCode('');
    setOperationDescription('');
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
    setCurrentExplanation('Created a linked list with Node structs containing values 10, 20, and 30. Head (Node* pointer) points to the first node struct.');
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
    setCurrentExplanation('Inserted a new Node struct (info=5) at the beginning. The newNode->link field points to the old head node, and head (Node* pointer) now points to the new node struct.');
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
    setCurrentExplanation('Inserted a new Node struct (info=40) at the end. Traversed using Node* pointer until reaching the last node, then set its link field (current->link) to point to the new node struct.');
  }, [state.head, allNodes]);

  const insertMiddle = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Create a list first.');
      return;
    }

    let p = state.head;
    if (!p.link) {
      setCurrentError('List has only one node. Cannot insert in middle.');
      return;
    }

    const newNode = createNode(25);
    const nodes = new Map(allNodes);
    nodes.set(newNode.id, newNode);
    
    newNode.link = p.link;
    p.link = newNode;
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
    }));
    setCurrentExplanation('Inserted a new Node struct (info=25) in the middle using C++ pointer operations. First, newNode->link was set to preserve the remainder of the list. Then p->link was updated to point to newNode. This is the CORRECT order for C++ struct manipulation.');
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
    
    p.link = newNode;
    newNode.link = p.link;
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
    }));
    setCurrentExplanation('DEMONSTRATION OF WRONG ORDER: First, p->link was set to newNode. Then newNode->link was set to p->link, which is now newNode itself! This creates a self-loop in the struct chain and loses the remainder of the list. This is why pointer order matters in C++!');
    setCurrentWarning('The list is now broken! The Node struct that was after p is now lost and unreachable (memory leak in C++).');
  }, [state.head, allNodes]);

  const deleteNode = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Nothing to delete.');
      return;
    }

    const nodes = new Map(allNodes);
    const oldHead = state.head;
    nodes.delete(oldHead.id);
    
    setAllNodes(nodes);
    setState(prev => ({
      ...prev,
      head: oldHead.link,
    }));
    setCurrentExplanation(`Deleted the first Node struct (info=${oldHead.info}) using 'delete' in C++. Head (Node* pointer) now points to the second node struct, or nullptr if the list is empty.`);
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

    setCurrentExplanation(`Traversed the list using Node* pointer. Visited Node structs with info values: ${values.join(' -> ')}${current ? ' (loop detected!)' : ''}. Used arrow operator (->) to access info and link fields.`);
  }, [state.head, allNodes]);

  const search = useCallback(() => {
    if (!state.head) {
      setCurrentError('List is empty. Nothing to search.');
      return;
    }

    const searchValue = 20;
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
      ? `Found Node struct with info=${searchValue} in the list using pointer traversal.`
      : `Node struct with info=${searchValue} not found in the list.`
    );
  }, [state.head]);

  const handleStartChallenge = useCallback((challenge: any) => {
    setCurrentChallenge(challenge);
    handleClear();
    createList();
    setCurrentExplanation(`Challenge started: ${challenge.title}. ${challenge.description}`);
  }, [handleClear, createList]);

  const handleShowCode = useCallback((code: string, description: string) => {
    setOperationCode(code);
    setOperationDescription(description);
  }, []);

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
          Linked List Visualizer (C++)
        </h1>
        <p style={{ fontSize: '18px', opacity: 0.9 }}>
          Learn C++ Structs and Pointers - Interactive Memory-Level Visualization
        </p>
        <div style={{ 
          background: 'rgba(255,255,255,0.2)', 
          padding: '10px', 
          borderRadius: '6px', 
          marginTop: '10px',
          fontSize: '14px'
        }}>
          <strong>Focus:</strong> C++ struct-based linked lists using Node* pointers and the arrow operator (-&gt;)
        </div>
      </header>

      <CppInfoPanel />
      <NotesPanel />
      <TraversalGuide onStepTraverse={traverse} />

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
            onShowCode={handleShowCode}
          />
        </div>

        <div>
          <CodeEditor
            onExecute={handleExecute}
            onClear={handleClear}
          />
          
          {operationCode && (
            <div style={{
              background: '#E3F2FD',
              padding: '15px',
              borderRadius: '8px',
              margin: '20px 0',
              border: '2px solid #2196F3'
            }}>
              <h4 style={{ 
                color: '#1976D2', 
                marginBottom: '8px',
                display: 'flex',
                alignItems: 'center',
                gap: '8px'
              }}>
                <Icon name="code" size={18} color="#1976D2" />
                Operation Code Executed
              </h4>
              <p style={{ color: '#666', fontSize: '13px', marginBottom: '10px' }}>
                {operationDescription}
              </p>
              <pre style={{
                margin: 0,
                fontFamily: 'monospace',
                fontSize: '12px',
                color: '#212529',
                background: 'white',
                padding: '12px',
                borderRadius: '4px',
                overflowX: 'auto',
                border: '1px solid #dee2e6'
              }}>
                {operationCode}
              </pre>
            </div>
          )}
          
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
};

const guide: GuideContent = {
  title: 'Linked List Traversal',
  sections: [
    {
      id: 'intro',
      title: 'What is Traversal?',
      content: 'Traversal is the process of visiting each node in a linked list exactly once.'
    },
    {
      id: 'algorithm',
      title: 'Traversal Algorithm',
      content: 'Start at head, follow links until NULL',
      code: 'current = head; while (current != NULL) { process(current); current = current->link; }'
    }
  ]
};

export const linkedListStructure: DataStructure = {
  id: 'linked_list',
  name: 'Linked List',
  category: 'linear',
  description: 'A linear data structure where elements are linked using pointers',
  available: true,
  Visualization: LinkedListVisualization,
  operations: [],
  guide: guide,
  Component: LinkedListComponent,
};

