import React, { useState, useEffect } from 'react';
import StructureSelector from './components/shared/StructureSelector';
import { StructureRegistry } from './structures/base/StructureInterface';
import { linkedListStructure } from './structures/linear/linked_list';
import { FiHome } from 'react-icons/fi';
import Icon from './components/shared/Icon';

// Register all structures
StructureRegistry.register(linkedListStructure);

// Placeholder structures for future
const placeholderStructures = [
  {
    id: 'array',
    name: 'Array',
    category: 'linear' as const,
    description: 'A collection of elements stored in contiguous memory locations',
    available: false,
  },
  {
    id: 'stack',
    name: 'Stack',
    category: 'linear' as const,
    description: 'A LIFO (Last In First Out) data structure',
    available: false,
  },
  {
    id: 'queue',
    name: 'Queue',
    category: 'linear' as const,
    description: 'A FIFO (First In First Out) data structure',
    available: false,
  },
  {
    id: 'tree',
    name: 'Binary Tree',
    category: 'non-linear' as const,
    description: 'A hierarchical data structure with nodes and edges',
    available: false,
  },
  {
    id: 'graph',
    name: 'Graph',
    category: 'non-linear' as const,
    description: 'A collection of nodes connected by edges',
    available: false,
  },
];

function App() {
  const [currentStructureId, setCurrentStructureId] = useState<string | null>(null);
  const [allStructures, setAllStructures] = useState<any[]>([]);

  useEffect(() => {
    const registered = StructureRegistry.getAll();
    const combined = [...registered, ...placeholderStructures];
    setAllStructures(combined);
    
    // Auto-select linked list if available
    if (registered.length > 0) {
      setCurrentStructureId(registered[0].id);
    }
  }, []);

  const handleSelectStructure = (structureId: string) => {
    setCurrentStructureId(structureId);
  };

  const handleBackToSelector = () => {
    setCurrentStructureId(null);
  };

  const currentStructure = currentStructureId 
    ? StructureRegistry.get(currentStructureId)
    : null;

  if (currentStructureId && currentStructure) {
    const StructureComponent = currentStructure.Component;
    return (
      <div>
        <button
          onClick={handleBackToSelector}
          style={{
            position: 'fixed',
            top: '20px',
            left: '20px',
            padding: '10px 20px',
            background: '#667eea',
            color: 'white',
            border: 'none',
            borderRadius: '6px',
            cursor: 'pointer',
            fontWeight: 'bold',
            display: 'flex',
            alignItems: 'center',
            gap: '8px',
            zIndex: 1000,
            boxShadow: '0 2px 8px rgba(0,0,0,0.2)'
          }}
        >
          <FiHome size={18} />
          Back to Structures
        </button>
        <StructureComponent />
      </div>
    );
  }

  return (
    <div style={{ 
      maxWidth: '1200px', 
      margin: '0 auto', 
      padding: '20px',
      minHeight: '100vh'
    }}>
      <header style={{ 
        textAlign: 'center', 
        marginBottom: '40px',
        color: 'white'
      }}>
        <h1 style={{ 
          fontSize: '42px', 
          marginBottom: '15px', 
          textShadow: '2px 2px 4px rgba(0,0,0,0.3)',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          gap: '15px'
        }}>
          <Icon name="list" size={40} />
          Data Structures Visualizer
        </h1>
        <p style={{ fontSize: '20px', opacity: 0.9 }}>
          Interactive Learning Platform for CS2 Data Structures
        </p>
        <p style={{ fontSize: '14px', opacity: 0.8, marginTop: '10px' }}>
          Learn Linear and Non-Linear data structures through hands-on visualization
        </p>
      </header>

      <StructureSelector
        structures={allStructures}
        currentStructureId={currentStructureId}
        onSelectStructure={handleSelectStructure}
      />
    </div>
  );
}

export default App;

