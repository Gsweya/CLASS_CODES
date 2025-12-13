import React, { useState } from 'react';
import Icon from '../shared/Icon';
import { FiCode, FiX } from 'react-icons/fi';

interface Props {
  onCreateList: () => void;
  onInsertBeginning: () => void;
  onInsertEnd: () => void;
  onInsertMiddle: () => void;
  onDelete: () => void;
  onTraverse: () => void;
  onSearch: () => void;
  onDemonstrateWrong: () => void;
  onShowCode?: (code: string, description: string) => void;
  disabled?: boolean;
}

interface OperationCode {
  name: string;
  code: string;
  description: string;
}

const operationCodes: Record<string, OperationCode> = {
  createList: {
    name: 'Create List',
    code: `// Create three nodes
Node* node1 = new Node;
node1->info = 10;
Node* node2 = new Node;
node2->info = 20;
Node* node3 = new Node;
node3->info = 30;

// Link them together
node1->link = node2;
node2->link = node3;
node3->link = nullptr;

// Set head pointer
head = node1;`,
    description: 'Creates a linked list with three nodes containing values 10, 20, and 30.'
  },
  insertBeginning: {
    name: 'Insert at Beginning',
    code: `// Create new node
Node* newNode = new Node;
newNode->info = 5;

// Link new node to current head
newNode->link = head;

// Update head to point to new node
head = newNode;`,
    description: 'Inserts a new node at the beginning of the list. The new node becomes the head.'
  },
  insertEnd: {
    name: 'Insert at End',
    code: `// Create new node
Node* newNode = new Node;
newNode->info = 40;
newNode->link = nullptr;

// Traverse to last node
Node* current = head;
while (current->link != nullptr) {
    current = current->link;
}

// Link last node to new node
current->link = newNode;`,
    description: 'Traverses to the end of the list and inserts a new node after the last node.'
  },
  insertMiddle: {
    name: 'Insert in Middle',
    code: `// Create new node
Node* newNode = new Node;
newNode->info = 25;

// CORRECT ORDER:
// 1. Preserve the remainder of the list
newNode->link = p->link;

// 2. Insert the new node
p->link = newNode;`,
    description: 'Inserts a node in the middle. Order matters! First preserve the remainder, then insert.'
  },
  delete: {
    name: 'Delete Node',
    code: `// Save reference to node to delete
Node* temp = head;

// Update head to next node
head = head->link;

// Free memory
delete temp;`,
    description: 'Deletes the first node and updates head. Memory is freed using delete.'
  },
  traverse: {
    name: 'Traverse',
    code: `Node* current = head;

while (current != nullptr) {
    // Process current node
    cout << current->info << " ";
    
    // Move to next node
    current = current->link;
}`,
    description: 'Visits each node from head to tail, processing the info field of each node.'
  },
  search: {
    name: 'Search',
    code: `int searchValue = 20;
Node* current = head;

while (current != nullptr) {
    if (current->info == searchValue) {
        // Found!
        return current;
    }
    current = current->link;
}
// Not found
return nullptr;`,
    description: 'Searches for a node with a specific info value by traversing the list.'
  },
  demonstrateWrong: {
    name: 'Demonstrate Wrong Order',
    code: `// WRONG ORDER - Creates a loop!
Node* newNode = new Node;
newNode->info = 99;

// WRONG: Setting p->link first
p->link = newNode;

// WRONG: Now newNode->link points to itself!
newNode->link = p->link;  // p->link is now newNode!

// Result: Loop created, remainder of list is lost!`,
    description: 'Demonstrates what happens when pointer operations are done in the wrong order - creates a loop and loses nodes!'
  }
};

const OperationButtons: React.FC<Props> = ({
  onCreateList,
  onInsertBeginning,
  onInsertEnd,
  onInsertMiddle,
  onDelete,
  onTraverse,
  onSearch,
  onDemonstrateWrong,
  onShowCode,
  disabled = false
}) => {
  const [showCodePanel, setShowCodePanel] = useState<string | null>(null);

  const buttonStyle = {
    padding: '10px 15px',
    margin: '5px',
    background: disabled ? '#ccc' : '#667eea',
    color: 'white',
    border: 'none',
    borderRadius: '6px',
    cursor: disabled ? 'not-allowed' : 'pointer',
    fontWeight: 'bold',
    fontSize: '13px',
    transition: 'all 0.2s',
    display: 'flex',
    alignItems: 'center',
    gap: '6px'
  };

  const handleOperation = (operationKey: string, operationFn: () => void) => {
    if (disabled) return;
    
    // Show code if handler provided
    if (onShowCode && operationCodes[operationKey]) {
      const op = operationCodes[operationKey];
      onShowCode(op.code, op.description);
      setShowCodePanel(operationKey);
    }
    
    // Execute operation
    operationFn();
  };

  return (
    <div style={{
      background: 'white',
      padding: '20px',
      borderRadius: '8px',
      boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
      margin: '20px 0'
    }}>
      <h3 style={{ marginBottom: '15px', color: '#333', display: 'flex', alignItems: 'center', gap: '8px' }}>
        <Icon name="list" size={20} color="#667eea" />
        Quick Operations
      </h3>
      <p style={{ fontSize: '12px', color: '#666', marginBottom: '15px', fontStyle: 'italic' }}>
        Click any operation to see the C++ code that executes, then observe the effect on the visualization.
      </p>
      
      <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px' }}>
        <button 
          onClick={() => handleOperation('createList', onCreateList)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Create List
        </button>
        <button 
          onClick={() => handleOperation('insertBeginning', onInsertBeginning)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Insert at Beginning
        </button>
        <button 
          onClick={() => handleOperation('insertEnd', onInsertEnd)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Insert at End
        </button>
        <button 
          onClick={() => handleOperation('insertMiddle', onInsertMiddle)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Insert in Middle
        </button>
        <button 
          onClick={() => handleOperation('delete', onDelete)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Delete Node
        </button>
        <button 
          onClick={() => handleOperation('traverse', onTraverse)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Traverse
        </button>
        <button 
          onClick={() => handleOperation('search', onSearch)} 
          disabled={disabled} 
          style={buttonStyle}
        >
          <Icon name="code" size={14} />
          Search
        </button>
        <button 
          onClick={() => handleOperation('demonstrateWrong', onDemonstrateWrong)} 
          disabled={disabled} 
          style={{...buttonStyle, background: disabled ? '#ccc' : '#e74c3c'}}
        >
          <Icon name="code" size={14} />
          Demonstrate Wrong Order
        </button>
      </div>

      {showCodePanel && operationCodes[showCodePanel] && (
        <div style={{
          marginTop: '15px',
          background: '#f8f9fa',
          padding: '15px',
          borderRadius: '6px',
          border: '2px solid #667eea',
          position: 'relative'
        }}>
          <button
            onClick={() => setShowCodePanel(null)}
            style={{
              position: 'absolute',
              top: '10px',
              right: '10px',
              background: 'transparent',
              border: 'none',
              cursor: 'pointer',
              fontSize: '18px',
              color: '#666'
            }}
          >
            <FiX />
          </button>
          <h4 style={{ 
            color: '#667eea', 
            marginBottom: '8px',
            display: 'flex',
            alignItems: 'center',
            gap: '8px'
          }}>
            <FiCode size={16} />
            {operationCodes[showCodePanel].name} - C++ Code
          </h4>
          <p style={{ color: '#666', fontSize: '13px', marginBottom: '10px' }}>
            {operationCodes[showCodePanel].description}
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
            {operationCodes[showCodePanel].code}
          </pre>
        </div>
      )}
    </div>
  );
};

export default OperationButtons;

