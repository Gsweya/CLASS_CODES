import React from 'react';
import Icon from '../shared/Icon';

const CppInfoPanel: React.FC = () => {
  return (
    <div style={{
      background: '#E3F2FD',
      padding: '15px',
      borderRadius: '8px',
      margin: '20px 0',
      border: '2px solid #2196F3'
    }}>
      <h4 style={{ 
        color: '#1976D2', 
        marginBottom: '10px',
        display: 'flex',
        alignItems: 'center',
        gap: '8px'
      }}>
        <Icon name="info" size={18} color="#1976D2" />
        C++ Focus - Structs and Pointers
      </h4>
      <p style={{ color: '#333', marginBottom: '10px', lineHeight: '1.6' }}>
        This visualizer focuses on <strong>C++ implementation</strong> using structs and pointers, 
        which is the primary method taught in this course.
      </p>
      <div style={{ 
        background: 'white', 
        padding: '12px', 
        borderRadius: '6px',
        marginBottom: '10px'
      }}>
        <strong style={{ color: '#1976D2' }}>Core C++ Concepts:</strong>
        <ul style={{ marginTop: '8px', paddingLeft: '20px', color: '#555', lineHeight: '1.8' }}>
          <li><code>struct Node</code> - Defines the node structure with <code>info</code> and <code>link</code> fields</li>
          <li><code>Node*</code> - Pointer type to point to Node structs</li>
          <li><code>{'->'}</code> - Arrow operator to access struct members through pointers</li>
          <li><code>new Node</code> - Dynamic memory allocation in C++</li>
          <li><code>delete</code> - Memory deallocation in C++</li>
          <li><code>nullptr</code> - C++ null pointer constant</li>
        </ul>
      </div>
      <p style={{ color: '#666', fontSize: '12px', fontStyle: 'italic', margin: 0 }}>
        Note: Other implementation methods (arrays, classes) may be mentioned briefly, but C++ structs 
        and pointers are the main focus for this course.
      </p>
    </div>
  );
};

export default CppInfoPanel;

