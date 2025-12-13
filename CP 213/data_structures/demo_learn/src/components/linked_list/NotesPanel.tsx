import React, { useState } from 'react';
import Icon from '../shared/Icon';
import { FiChevronDown, FiChevronUp } from 'react-icons/fi';

const NotesPanel: React.FC = () => {
  const [isExpanded, setIsExpanded] = useState(true);

  return (
    <div style={{
      background: 'white',
      padding: '20px',
      borderRadius: '8px',
      boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
      margin: '20px 0'
    }}>
      <div
        onClick={() => setIsExpanded(!isExpanded)}
        style={{
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          cursor: 'pointer',
          marginBottom: isExpanded ? '15px' : 0
        }}
      >
        <h3 style={{ 
          margin: 0, 
          color: '#333',
          display: 'flex',
          alignItems: 'center',
          gap: '10px'
        }}>
          <Icon name="book" size={20} color="#667eea" />
          Linked List Notes & Summary
        </h3>
        {isExpanded ? <FiChevronUp size={20} /> : <FiChevronDown size={20} />}
      </div>

      {isExpanded && (
        <div>
          {/* What is a Linked List */}
          <section style={{ marginBottom: '25px' }}>
            <h4 style={{ 
              color: '#667eea', 
              marginBottom: '10px',
              display: 'flex',
              alignItems: 'center',
              gap: '8px'
            }}>
              <Icon name="help" size={16} />
              What is a Linked List?
            </h4>
            <p style={{ color: '#555', lineHeight: '1.6', marginBottom: '10px' }}>
              A <strong>linked list</strong> is a linear data structure where elements (nodes) are stored 
              in non-contiguous memory locations. Each node contains:
            </p>
            <ul style={{ marginLeft: '20px', color: '#555', lineHeight: '1.8', marginBottom: '10px' }}>
              <li><code>info</code> - The data stored in the node</li>
              <li><code>link</code> - A pointer (Node*) to the next node in the list</li>
            </ul>
            <p style={{ color: '#555', lineHeight: '1.6' }}>
              The list is accessed through a <code>head</code> pointer (Node*) that points to the first node. 
              The last node's <code>link</code> field is <code>nullptr</code>, indicating the end of the list.
            </p>
          </section>

          {/* Node Structure */}
          <section style={{ marginBottom: '25px' }}>
            <h4 style={{ 
              color: '#667eea', 
              marginBottom: '10px',
              display: 'flex',
              alignItems: 'center',
              gap: '8px'
            }}>
              <Icon name="code" size={16} />
              Node Structure in C++
            </h4>
            <div style={{
              background: '#f8f9fa',
              padding: '15px',
              borderRadius: '6px',
              border: '1px solid #dee2e6'
            }}>
              <pre style={{
                margin: 0,
                fontFamily: 'monospace',
                fontSize: '13px',
                color: '#212529',
                background: 'white',
                padding: '10px',
                borderRadius: '4px',
                overflowX: 'auto'
              }}>
{`struct Node {
    int info;        // Data field
    Node* link;      // Pointer to next node
};

Node* head = nullptr;  // Head pointer`}
              </pre>
            </div>
          </section>

          {/* Key Operations */}
          <section style={{ marginBottom: '25px' }}>
            <h4 style={{ 
              color: '#667eea', 
              marginBottom: '15px',
              display: 'flex',
              alignItems: 'center',
              gap: '8px'
            }}>
              <Icon name="list" size={16} />
              Key Operations Summary
            </h4>
            
            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                1. Create List
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Initialize a linked list by creating nodes and connecting them via link pointers.
              </p>
            </div>

            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                2. Insert at Beginning
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Create a new node, set its link to point to the current head, then update head to point to the new node.
              </p>
            </div>

            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                3. Insert at End
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Traverse to the last node, then set its link field to point to the new node.
              </p>
            </div>

            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                4. Insert in Middle
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Find the insertion point, set newNode-&gt;link to preserve the remainder, then update the previous node's link.
              </p>
            </div>

            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                5. Delete Node
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Update pointers to bypass the node, then use <code>delete</code> to free memory.
              </p>
            </div>

            <div style={{ marginBottom: '15px' }}>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                6. Traverse
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Visit each node from head to tail using a Node* pointer, following link fields until nullptr.
              </p>
            </div>

            <div>
              <h5 style={{ color: '#495057', marginBottom: '8px', fontSize: '14px' }}>
                7. Search
              </h5>
              <p style={{ color: '#6c757d', fontSize: '13px', marginBottom: '5px' }}>
                Traverse the list comparing each node's info field with the search value.
              </p>
            </div>
          </section>

          {/* Important Concepts */}
          <section style={{ marginBottom: '25px' }}>
            <h4 style={{ 
              color: '#667eea', 
              marginBottom: '15px',
              display: 'flex',
              alignItems: 'center',
              gap: '8px'
            }}>
              <Icon name="info" size={16} />
              Important C++ Concepts
            </h4>
            <ul style={{ 
              margin: 0, 
              paddingLeft: '20px',
              color: '#555',
              lineHeight: '1.8'
            }}>
              <li><strong>Node*</strong> - Pointer type that points to Node structs</li>
              <li><strong>{'->'}</strong> - Arrow operator to access struct members through pointers</li>
              <li><strong>new Node</strong> - Dynamically allocates memory for a new Node struct</li>
              <li><strong>delete</strong> - Deallocates memory (prevents memory leaks)</li>
              <li><strong>nullptr</strong> - C++ null pointer constant (end of list marker)</li>
              <li><strong>Pointer Order Matters</strong> - Wrong order can lose nodes or create loops</li>
            </ul>
          </section>

          {/* Common Patterns */}
          <section>
            <h4 style={{ 
              color: '#667eea', 
              marginBottom: '15px',
              display: 'flex',
              alignItems: 'center',
              gap: '8px'
            }}>
              <Icon name="target" size={16} />
              Common Patterns
            </h4>
            <div style={{
              background: '#f8f9fa',
              padding: '12px',
              borderRadius: '6px',
              marginBottom: '10px',
              border: '1px solid #dee2e6'
            }}>
              <strong style={{ color: '#495057', fontSize: '13px' }}>Traversal Pattern:</strong>
              <pre style={{
                margin: '8px 0 0 0',
                fontFamily: 'monospace',
                fontSize: '12px',
                color: '#212529',
                background: 'white',
                padding: '8px',
                borderRadius: '4px',
                overflowX: 'auto'
              }}>
{`Node* current = head;
while (current != nullptr) {
    // Process current->info
    current = current->link;
}`}
              </pre>
            </div>
            <div style={{
              background: '#f8f9fa',
              padding: '12px',
              borderRadius: '6px',
              border: '1px solid #dee2e6'
            }}>
              <strong style={{ color: '#495057', fontSize: '13px' }}>Insert in Middle (Correct Order):</strong>
              <pre style={{
                margin: '8px 0 0 0',
                fontFamily: 'monospace',
                fontSize: '12px',
                color: '#212529',
                background: 'white',
                padding: '8px',
                borderRadius: '4px',
                overflowX: 'auto'
              }}>
{`newNode->link = p->link;  // Preserve remainder
p->link = newNode;          // Insert new node`}
              </pre>
            </div>
          </section>
        </div>
      )}
    </div>
  );
};

export default NotesPanel;

