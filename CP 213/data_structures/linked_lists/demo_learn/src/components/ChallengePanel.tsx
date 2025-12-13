import React from 'react';

interface Challenge {
  id: string;
  title: string;
  description: string;
  goal: string;
  hints: string[];
}

interface Props {
  currentChallenge: Challenge | null;
  onStartChallenge: (challenge: Challenge) => void;
  score: number;
}

const challenges: Challenge[] = [
  {
    id: '1',
    title: 'Insert After Value',
    description: 'Insert a node with value 50 after the node containing value 65',
    goal: 'Insert 50 after 65 without losing any nodes',
    hints: [
      'First, traverse to find the node with value 65',
      'Use two statements: newNode->link = p->link, then p->link = newNode',
      'Order matters! Do not reverse these statements'
    ]
  },
  {
    id: '2',
    title: 'Fix the Broken List',
    description: 'A list was broken by incorrect pointer manipulation. Restore it.',
    goal: 'Reconnect all lost nodes to the main list',
    hints: [
      'Identify which nodes are marked as "Lost / Unreachable"',
      'You may need to traverse to find where the break occurred',
      'Reconnect the lost portion by setting the correct link pointer'
    ]
  },
  {
    id: '3',
    title: 'Identify Infinite Loop',
    description: 'The list has a loop causing infinite traversal. Find and fix it.',
    goal: 'Break the loop and restore proper list structure',
    hints: [
      'Look for the red looping arrow in the visualization',
      'Find where a node points back to a previous node',
      'Set the appropriate link to NULL to break the loop'
    ]
  }
];

const ChallengePanel: React.FC<Props> = ({ currentChallenge, onStartChallenge, score }) => {
  return (
    <div style={{
      background: 'white',
      padding: '20px',
      borderRadius: '8px',
      boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
      margin: '20px 0'
    }}>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '15px' }}>
        <h3 style={{ color: '#333', margin: 0 }}>Challenges</h3>
        <div style={{ fontSize: '18px', fontWeight: 'bold', color: '#667eea' }}>
          Score: {score}
        </div>
      </div>

      {currentChallenge ? (
        <div style={{
          background: '#E3F2FD',
          padding: '15px',
          borderRadius: '6px',
          border: '2px solid #2196F3',
          marginBottom: '15px'
        }}>
          <h4 style={{ color: '#1976D2', marginBottom: '10px' }}>
            Current Challenge: {currentChallenge.title}
          </h4>
          <p style={{ color: '#333', marginBottom: '10px' }}>
            {currentChallenge.description}
          </p>
          <p style={{ color: '#1976D2', fontWeight: 'bold', marginBottom: '10px' }}>
            Goal: {currentChallenge.goal}
          </p>
          <div>
            <strong style={{ color: '#1976D2' }}>Hints:</strong>
            <ul style={{ marginTop: '5px', paddingLeft: '20px' }}>
              {currentChallenge.hints.map((hint, idx) => (
                <li key={idx} style={{ color: '#555', marginBottom: '5px' }}>
                  {hint}
                </li>
              ))}
            </ul>
          </div>
        </div>
      ) : (
        <div style={{ color: '#666', marginBottom: '15px' }}>
          No active challenge. Select one below to start.
        </div>
      )}

      <div>
        {challenges.map(challenge => (
          <div
            key={challenge.id}
            style={{
              background: '#f8f9fa',
              padding: '12px',
              borderRadius: '6px',
              marginBottom: '10px',
              border: '1px solid #ddd',
              cursor: 'pointer',
              transition: 'all 0.2s'
            }}
            onClick={() => onStartChallenge(challenge)}
            onMouseEnter={(e) => {
              e.currentTarget.style.background = '#e9ecef';
            }}
            onMouseLeave={(e) => {
              e.currentTarget.style.background = '#f8f9fa';
            }}
          >
            <div style={{ fontWeight: 'bold', color: '#333', marginBottom: '5px' }}>
              {challenge.title}
            </div>
            <div style={{ fontSize: '12px', color: '#666' }}>
              {challenge.description}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ChallengePanel;


