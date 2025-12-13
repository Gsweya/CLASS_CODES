// Core data structures for linked list visualization

export interface ListNode {
  id: string;
  info: number | null;
  link: ListNode | null;
  isHighlighted?: boolean;
  isLost?: boolean;
  isCurrent?: boolean;
}

export interface PointerVariable {
  name: string;
  node: ListNode | null;
  color: string;
}

export interface ExecutionState {
  head: ListNode | null;
  pointers: Map<string, ListNode | null>;
  explanation: string;
  stepNumber: number;
  hasLoop: boolean;
  lostNodes: Set<string>;
}

export type StatementType = 
  | 'assign'
  | 'dereference'
  | 'create'
  | 'delete'
  | 'traverse'
  | 'search';

export interface Statement {
  id: string;
  text: string;
  type: StatementType;
  executed: boolean;
}

